<?php

namespace App\Http\Controllers\Compras\Documentos;

use App\Compras\Documento\Documento;
use App\Http\Controllers\Controller;
use App\Pos\Caja;
use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use DB;
use Session;
use App\Compras\Documento\Pago\Pago;


//PAGOS 
use App\Compras\Documento\Pago\Detalle as Detalle_Pago;
use App\Compras\Documento\Pago\PagoDetalle as Pivot_Pago;


class PagoController extends Controller
{
    public function index($id)
    {
        $documento = Documento::findOrFail($id);
        foreach(tipos_moneda() as $moneda){
            if ($moneda->descripcion == $documento->moneda) {
                $tipo_moneda= $moneda->simbolo;
            }
        }
        $monto = calcularMontoDocumento($documento->id);
        $suma_detalle_pago = calcularMontosAcuentaDocumentos($id);
        // CALCULAR SALDO
        $saldo = $monto - $suma_detalle_pago;
        // dd($suma_detalle_pago);


        // $documento = Documento::findOrFail($id);
        if ($suma_detalle_pago == $monto) {;
            $documento->estado = "PAGADA";
            $documento->update();
        }else{
            $documento->estado = "PENDIENTE";
            $documento->update();
        }

        // dd($suma_detalle_pago);


        return view('compras.documentos.pagos.index',[
            'documento' => $documento,
            'moneda' => $tipo_moneda,
            'monto' => $monto,
            'acuenta' =>  number_format($suma_detalle_pago, 2, '.', ''),
            'saldo' => number_format($saldo, 2, '.', ''),
        ]);
    }

    public function create($id)
    {
        $documento = Documento::findOrFail($id);
        $fecha_hoy = Carbon::now()->toDateString();
        $monedas =  tipos_moneda();
        $cajas = Caja::where('moneda','=',$documento->moneda)->where('estado','APERTURADA')->get();
        $suma_detalle_pago = calcularMontosAcuentaDocumentos($id);
        $monto = calcularMontoDocumento($documento->id);
        $monto_restante = $monto - $suma_detalle_pago;

        $bancos_proveedor = collect([]);
        $bancos_empresa = collect([]);

        foreach($documento->proveedor->bancos as $moneda_bancos){
                $bancos_proveedor->push([
                    'id' => $moneda_bancos->id,
                    'descripcion'=> $moneda_bancos->descripcion,
                    'tipo_moneda' => $moneda_bancos->tipo_moneda,
                    'num_cuenta'=> $moneda_bancos->num_cuenta,
                    'cci'=> $moneda_bancos->cci,
                    'estado'=> $moneda_bancos->estado,
                ]);
        }

        foreach($documento->empresa->bancos as $moneda_bancos){
            $bancos_empresa->push([
                'id' => $moneda_bancos->id,
                'descripcion'=> $moneda_bancos->descripcion,
                'tipo_moneda' => $moneda_bancos->tipo_moneda,
                'num_cuenta'=> $moneda_bancos->num_cuenta,
                'cci'=> $moneda_bancos->cci,
                'estado'=> $moneda_bancos->estado,
            ]);
        }

        return view('compras.documentos.pagos.create',[
            'documento' => $documento,
            'fecha_hoy' => $fecha_hoy,
            'monedas' => $monedas,
            'cajas' => $cajas,
            'monto' =>  number_format($monto_restante, 2, '.', ''),
            'bancos_proveedor' => $bancos_proveedor,
            'bancos_empresa' => $bancos_empresa,
        ]);
    }

    public function getBox($id)
    {
        // $suma_detalle_pago = Detalle_Pago::where('caja_id', $id)->sum('monto');
        $suma_detalle_pago =  calcularMontoRestanteCaja($id);
        $caja_monto = Caja::findOrFail($id);
        $monto_restante_caja = $caja_monto->saldo_inicial-$suma_detalle_pago;
        return $monto_restante_caja;
    }

    public function store(Request $request)
    {
        // dd($request);

        $data = $request->all();
        $rules = [
            'tipo_pago'=> 'required',            
        ];
        $message = [
            'tipo_pago.required' => 'El campo Tipo de Pago es obligatorio.',
        ];
        Validator::make($data, $rules, $message)->validate();


        $pago = new Pago();
        $pago->documento_id =  $request->get('id_documento');
        $pago->observacion =  $request->get('observacion');
        $pago->tipo_pago =  $request->get('tipo_pago');
        $pago->save();
        //Llenado de los articulos
        $pagosJSON = $request->get('pagos_tabla');
        $pagotabla = json_decode($pagosJSON[0]);

        foreach ($pagotabla as $tabla) {
            $detalle = Detalle_Pago::create([
                'caja_id' => $tabla->caja_id,
                'monto' => $tabla->monto,
            ]);

            $pivot = Pivot_pago::create([
                'pago_id' => $pago->id,
                'detalle_id' => $detalle->id,
            ]);
        }

        $documento = Documento::findOrFail($request->get('id_documento'));
        $documento->tipo_pago = '0';
        $documento->update();

        Session::flash('success','Pago creado.');
        return redirect()->route('compras.documentos.pago.index',$request->get('id_documento'))->with('guardar', 'success');
        
      

    }

    public function destroy($id)
    {
        $pago = Pago::findOrFail($id);
        $pago->estado = 'ANULADO';
        $pago->update();

        Session::flash('success','Documento de Compra eliminada.');
        return redirect()->route('compras.documentos.pago.index',$pago->documento->id)->with('guardar', 'success');

    }

    public function getPayDocument($id)
    {
        
        $pagos = DB::table('documento_pago_detalle')
        ->join('compra_documento_pagos','compra_documento_pagos.id','=','documento_pago_detalle.pago_id')
        ->join('compra_documento_pago_detalle','compra_documento_pago_detalle.id','=','documento_pago_detalle.detalle_id')
        ->join('compra_documentos','compra_documentos.id','=','compra_documento_pagos.documento_id')
        ->select('compra_documento_pagos.*','compra_documentos.*','compra_documento_pago_detalle.monto as monto_detalle','compra_documento_pagos.id as pago_cabecera_id','compra_documento_pagos.tipo_pago as tipo_pago_cabecera')        
        ->where('compra_documentos.id','=',$id)
        ->where('compra_documento_pagos.estado','!=','ANULADO')
        ->get();


        $coleccion = collect([]);

        
        foreach($pagos as $pago){
            $tipo_moneda = '';
            foreach(tipos_moneda() as $moneda){
                if ($moneda->descripcion == $pago->moneda) {
                    $tipo_moneda= $moneda->simbolo;
                }
            }

            
                $coleccion->push([
                    'id' => $pago->pago_cabecera_id,
                    'tipo' => $pago->tipo_pago_cabecera,
                    'moneda' => $pago->moneda,
                    'pago_fecha' => Carbon::parse($pago->created_at)->format( 'd/m/Y - H:i:s'),
                    'monto' => $tipo_moneda.' '.number_format($pago->monto_detalle,2,'.',''),
                    ]);
            


        }
            
        
        return DataTables::of($coleccion)->toJson();   
    }

    public function show($id)
    {
        $pago = Pivot_pago::where('detalle_id',$id)->first();
        $tipo_moneda = "";
        foreach(tipos_moneda() as  $moneda){
            if ($moneda->descripcion == $pago->pago->documento->moneda) {
                $tipo_moneda= $moneda->simbolo;
            }
        }
        return view('compras.documentos.pagos.show',[
            'pago' => $pago,
            'tipo_moneda' => $tipo_moneda
        ]);

    }




}
