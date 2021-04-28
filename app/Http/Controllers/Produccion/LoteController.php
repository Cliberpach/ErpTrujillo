<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Produccion\Orden;
use App\Almacenes\LoteProducto;
use Session;
use Carbon\Carbon;

class LoteController extends Controller
{
    public function store(Request $request)
    {
     
        $data = $request->all();
        $rules = [
            'orden_produccion' => 'required',
            'cantidad' => 'required',
            'fecha_entrega'=>'required',
            'lote_producto'=>'required',
            'observacion'=> 'nullable'
        ];

        $message = [
            'required.orden_produccion'=>'El campo Orden de Producción es obligatorio',
            'required.cantidad'=>'El campo Cantidad es obligatorio',
            'required.fecha_entrega'=>'El campo Fecha de Entrega es obligatorio',
            'required.lote_producto'=>'El campo Lote de Producción es obligatorio',
        ];

        Validator::make($data, $rules, $message)->validate();

        //BUSCAR ORDEN
        $orden = Orden::findOrFail($request->get('orden_produccion'));
        //INGRESAR LOTE
        $lote = new LoteProducto;
        $lote->orden_id = $orden->id;
        $lote->codigo = $request->get('lote_producto');
        $lote->producto_id = $orden->producto_id;
        $lote->codigo_producto = $orden->codigo_producto;
        $lote->descripcion_producto = $orden->descripcion_producto;
        $lote->cantidad = $request->get('cantidad');
        $lote->cantidad_logica = $request->get('cantidad');
        $lote->fecha_vencimiento = $orden->fecha_produccion;
        $lote->observacion = $request->get('observacion');
        $lote->fecha_entrega = Carbon::createFromFormat('d/m/Y', $request->get('fecha_entrega'))->format('Y-m-d');
        $lote->confor_almacen = ($request->get('confirmacion_almacen')) ? '1' : null;
        $lote->confor_produccion = ($request->get('confirmacion_produccion')) ? '1' : null;
        $lote->save();
    
        if ( $request->get('confirmacion_almacen') == 'on' && $request->get('confirmacion_produccion') == 'on' ) {
            //ORDEN DE CONFIRMACION CAMBIANDO
            $orden->conformidad = '1';
            $orden->editable = '2';
            $orden->update();
            Session::flash('success','Orden de Produccion Confirmada');
            return redirect()->route('produccion.orden.index')->with('guardar', 'success');
        }

        if ( $request->get('confirmacion_almacen') == 'on') {
            $orden->conformidad = '0';
            $orden->editable = '1';
            $orden->update();
            Session::flash('error','No se encuentra la confirmacion del Área de Producción');
            return redirect()->route('produccion.orden.index')->with('error_orden_produccion', 'error');

        }

        if ($request->get('confirmacion_produccion') == 'on' ) {
            $orden->conformidad = '0';
            $orden->editable = '1';
            Session::flash('error','No se encuentra la confirmacion del Área de Almacen');
            return redirect()->route('produccion.orden.index')->with('error_orden_almacen', 'error');

        }

        $orden->conformidad = '0';
        $orden->editable = '1';
        $orden->update();
        Session::flash('error','Debe de ingresar las conformidades de las Áreas');
        return redirect()->route('produccion.orden.index')->with('error_orden_areas', 'error');

       
    }

    public function edit($id)
    {
        $lote = LoteProducto::where('orden_id',$id)->first();
        $orden = Orden::findOrFail($id);

        return  response()->json([
            'lote' => $lote,
            'orden' => $orden
        ]); 
    }


    public function update(Request $request)
    {
        $data = $request->all();
        $rules = [
            'orden_produccion' => 'required',
            'cantidad' => 'required',
            'fecha_entrega'=>'required',
            'lote_producto'=>'required',
            'observacion'=> 'nullable'
        ];

        $message = [
            'required.orden_produccion'=>'El campo Orden de Producción es obligatorio',
            'required.cantidad'=>'El campo Cantidad es obligatorio',
            'required.fecha_entrega'=>'El campo Fecha de Entrega es obligatorio',
            'required.lote_producto'=>'El campo Lote de Producción es obligatorio',
        ];

        Validator::make($data, $rules, $message)->validate();

        //BUSCAR ORDEN
        $orden = Orden::findOrFail($request->get('orden_produccion'));
        //INGRESAR LOTE
        $lote = LoteProducto::findOrFail($request->get('lote_id'));
        $lote->orden_id = $orden->id;
        $lote->codigo = $request->get('lote_producto');
        $lote->producto_id = $orden->producto_id;
        $lote->codigo_producto = $orden->codigo_producto;
        $lote->descripcion_producto = $orden->descripcion_producto;
        $lote->cantidad = $request->get('cantidad');
        $lote->cantidad_logica = $request->get('cantidad');
        $lote->fecha_vencimiento = $orden->fecha_produccion;
        $lote->observacion = $request->get('observacion');
        $lote->fecha_entrega = Carbon::createFromFormat('d/m/Y', $request->get('fecha_entrega'))->format('Y-m-d');
        $lote->confor_almacen = ($request->get('confirmacion_almacen')) ? '1' : null;
        $lote->confor_produccion = ($request->get('confirmacion_produccion')) ? '1' : null;
        $lote->update();
    
        if ( $request->get('confirmacion_almacen') == 'on' && $request->get('confirmacion_produccion') == 'on' ) {
            //ORDEN DE CONFIRMACION CAMBIANDO
            $orden->conformidad = '1';
            $orden->editable = '2';
            $orden->update();
            Session::flash('success','Orden de Produccion Confirmada');
            return redirect()->route('produccion.orden.index')->with('guardar', 'success');
        }

        if ( $request->get('confirmacion_almacen') == 'on') {
            $orden->conformidad = '0';
            $orden->editable = '1';
            $orden->update();
            Session::flash('error','No se encuentra la confirmacion del Área de Producción');
            return redirect()->route('produccion.orden.index')->with('error_orden_produccion', 'error');

        }

        if ($request->get('confirmacion_produccion') == 'on' ) {
            $orden->conformidad = '0';
            $orden->editable = '1';
            Session::flash('error','No se encuentra la confirmacion del Área de Almacen');
            return redirect()->route('produccion.orden.index')->with('error_orden_almacen', 'error');

        }

        $orden->conformidad = '0';
        $orden->editable = '1';
        $orden->update();
        Session::flash('error','Debe de ingresar las conformidades de las Áreas');
        return redirect()->route('produccion.orden.index')->with('error_orden_areas', 'error');

       
    }
}
