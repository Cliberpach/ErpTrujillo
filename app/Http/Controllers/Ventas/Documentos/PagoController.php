<?php

namespace App\Http\Controllers\Ventas\Documentos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Pos\Caja;
use DataTables;
use Carbon\Carbon;
use App\Ventas\Documento\Documento;
use Session;
use Illuminate\Support\Facades\Validator;
use DB;

use App\Ventas\Documento\Pago\Pago;
use App\Ventas\Documento\Pago\Caja as CajaPago; 
use App\Ventas\Documento\Pago\PagoDetalle as Pivot_pago; 
use Redirect;


class PagoController extends Controller
{
    public function index($id)
    {
        $documento = Documento::findOrFail($id);

        $acuenta = calcularMontosAcuentaVentas($id);        
        // CALCULAR SALDO
        $saldo = $documento->total - $acuenta;
        
        if ($documento->total == $acuenta) {;
            $documento->estado = "PAGADA";
            $documento->update();
        }else{
            $documento->estado = "PENDIENTE";
            $documento->update();
        }


        return view('ventas.documentos.pagos.index',[
            'documento' => $documento,
            'monto' => $documento->total,
            'acuenta' =>  number_format($acuenta, 2, '.', ''),
            'saldo' => number_format($saldo, 2, '.', ''),
        ]);
    }

    public function create($id)
    {
        $documento = Documento::findOrFail($id);
        $fecha_hoy = Carbon::now()->toDateString();
        $cajas = Caja::where('moneda','=','SOLES')->where('estado','APERTURADA')->get();
        $acuenta = calcularMontosAcuentaVentas($id);        
        // CALCULAR SALDO
        $saldo = $documento->total - $acuenta;

        return view('ventas.documentos.pagos.create',[
            'documento' => $documento,
            'fecha_hoy' => $fecha_hoy,
            'cajas' => $cajas,
            'monto' =>  number_format($saldo, 2, '.', ''),

        ]);
    }

    public function store(Request $request)
    {

        $data = $request->all();
        $rules = [
            'tipo_pago'=> 'required',            
        ];
        $message = [
            'tipo_pago.required' => 'El campo Tipo de Pago es obligatorio.',
        ];
        Validator::make($data, $rules, $message)->validate();


        $venta = new Pago();
        $venta->documento_id =  $request->get('id_documento');
        $venta->total =  $request->get('total');
        $venta->observacion =  $request->get('observacion');
        $venta->tipo_pago =  $request->get('tipo_pago');
        $venta->save();

        
        //Llenado de los articulos

        $pagosJSON = $request->get('pagos_tabla');
        $pagotabla = json_decode($pagosJSON[0]);

        foreach ($pagotabla as $tabla) {

            //AGREGAR CAJA
            $detalle =  new CajaPago();
            $detalle->caja_id = $tabla->caja_id;
            $detalle->monto = $tabla->monto;
            $detalle->save();

            // //AGREGAR A TABLA PIVOT
            $pivot = new Pivot_pago();
            $pivot->pago_id = $venta->id;
            $pivot->caja_id = $detalle->id;
            $pivot->save();

        }

        $documento = Documento::findOrFail($request->get('id_documento'));
        //TIPO DE PAGO : OTROS
        $documento->tipo_pago = '0';
        $documento->update();
        
        //Registro de actividad
        $descripcion = "SE AGREGÓ EL PAGO DEL DOCUMENTO DE VENTA CON EL MONTO: ".  $venta->total ;
        $gestion = "DOCUMENTO DE VENTA";
        crearRegistro($venta, $descripcion , $gestion);

        Session::flash('success','Pago creado.');
        return redirect()->route('ventas.documentos.pago.index',$request->get('id_documento'))->with('guardar', 'success');
        
    }

    public function destroy($id)
    {
        
        $pago = CajaPago::findOrFail($id);
        $pago->estado = 'ANULADO';
        $pago->update();

        //Registro de actividad
        $descripcion = "SE ELIMINÓ EL PAGO DEL DOCUMENTO DE VENTA CON EL MONTO: ".  $pago->monto ;
        $gestion = "DOCUMENTO DE VENTA";
        crearRegistro($pago, $descripcion , $gestion);

        Session::flash('success','Pago del documento de venta eliminada.');
        return redirect::back()->with('guardar', 'success');

    }

    public function getPayDocument($id)
    {
        

        $pagos = DB::table('cotizacion_documento_pago_detalle_cajas')
                ->join('cotizacion_documento_pagos','cotizacion_documento_pagos.id','=','cotizacion_documento_pago_detalle_cajas.pago_id')
                ->join('cotizacion_documento','cotizacion_documento.id','=','cotizacion_documento_pagos.documento_id')
                ->join('cotizacion_documento_pago_cajas','cotizacion_documento_pago_cajas.id','=','cotizacion_documento_pago_detalle_cajas.caja_id')
                ->join('pos_caja_chica','pos_caja_chica.id','=','cotizacion_documento_pago_cajas.caja_id')
                ->join('colaboradores','colaboradores.id','=','pos_caja_chica.colaborador_id')
                ->join('personas','personas.id','=','colaboradores.persona_id')

                ->select('cotizacion_documento.id as id_documento', 'cotizacion_documento_pago_detalle_cajas.id',
                'cotizacion_documento_pago_cajas.monto as caja_monto',
                'cotizacion_documento_pagos.tipo_pago', 'cotizacion_documento_pago_detalle_cajas.created_at',DB::raw('CONCAT(personas.apellido_materno,\' \',personas.apellido_paterno,\' \',personas.nombres) AS nombre_completo') )        
                ->where('cotizacion_documento.id','=',$id)
                //ANULAR
                ->where('cotizacion_documento_pago_cajas.estado','!=','ANULADO')
                ->get();

        $coleccion = collect([]);

        
        foreach($pagos as $pago){
            
            $coleccion->push([
                'id' => $pago->id,
                'tipo' => $pago->tipo_pago,
                'empleado_caja' => $pago->nombre_completo,
                'pago_fecha' => Carbon::parse($pago->created_at)->format( 'd/m/Y - H:i:s'),
                'monto' => 'S/. '.number_format($pago->caja_monto,2,'.',''),
            ]);
        }
        return DataTables::of($coleccion)->toJson();   
    }

    public function show($id)
    {
        $pago = Pivot_pago::where('caja_id',$id)->first();
        return view('ventas.documentos.pagos.show',[
            'pago' => $pago,
        ]);

    }



}
