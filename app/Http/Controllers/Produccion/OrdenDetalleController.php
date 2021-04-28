<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Compras\Articulo;
use App\Produccion\Programacion_produccion;
use App\Almacenes\ProductoDetalle;
use App\Compras\LoteArticulo;
use DB;
use App\Almacenes\Producto;

use App\Produccion\Orden; //ORDEN DE PRODUCCION
use App\Produccion\OrdenDetalle; // DETALLE DE LA ORDEN DE PRODUCCION
use App\Produccion\OrdenDetalleLote; // DETALLE DEL ARTICULO (LOTES PRODUCCION / EXCEDIDA)
use App\Produccion\Devolucion; // DEVOLUCION 
use Session;
use Illuminate\Support\Collection;

use App\Movimientos\MovimientoAlmacen;
use App\Movimientos\MovimientoAlmacenDetalle;

class OrdenDetalleController extends Controller
{
    public function create(Request $request)
    {
        $articulo= Articulo::findOrFail($request->articulo_id);
        $programacion= Programacion_produccion::findOrFail($request->programacion_id);
        $productodetalles = ProductoDetalle::where('producto_id',$programacion->producto_id)
                            ->where('articulo_id',$articulo->id)
                            ->where('estado','ACTIVO')->first();
        $cantidadProduccion = $programacion->cantidad_programada * $productodetalles->cantidad;
        $cantidadProduccionCompleta = $programacion->cantidad_programada * $productodetalles->cantidad.' '.$productodetalles->articulo->getMedida();
        $lotes = LoteArticulo::where('articulo_id',$articulo->id)
                            ->where('cantidad_logica','>',0)
                            ->where('estado','1')->get();
    
    
        return view('produccion.ordenes.detallesLotes.create',[
            'articulo'=> $articulo,
            'programacion' => $programacion,
            'cantidadProduccion' => $cantidadProduccion,
            'cantidadProduccionCompleta' => $cantidadProduccionCompleta,
            'lotes' => $lotes,

        ]);
    }

    public function edit(Request $request)
    {
        
        $articulo = Articulo::findOrFail($request->articulo_id);
        $programacion = Programacion_produccion::findOrFail($request->programacion_id);
        $ordenDetalle = OrdenDetalle::findOrFail($request->ordenDetalle);
       
        $loteCantidadProduccion = OrdenDetalleLote::where('tipo_cantidad','PRODUCCION')->where('orden_produccion_detalle_id',$ordenDetalle->id)->get();
        if ($loteCantidadProduccion->count() > 0) {
            $lotes = 0;
        }else{
            $lotes = self::getLot($articulo->id, $ordenDetalle);
        }
        
        $loteCantidadExcedida = OrdenDetalleLote::where('tipo_cantidad','EXCEDIDA')->where('orden_produccion_detalle_id',$ordenDetalle->id)->get();
        
        return view('produccion.ordenes.detallesLotes.edit',[
            'articulo'=> $articulo,
            'programacion' => $programacion,
            'ordenDetalle' => $ordenDetalle,
            'cantidadProducciones' => $loteCantidadProduccion,
            'lotes' => $lotes,
            'cantidadExcedidas' => $loteCantidadExcedida,
        ]);

    }

    // OBTENER LOTES 
    public function getLot($articulo_id, $ordenDetalle)
    {       
        $nuevoDetalle = collect();
   
        $lotes = LoteArticulo::where('articulo_id',$articulo_id)
                ->where('estado','1')
                ->where('cantidad_logica','>',0)
                ->orderBy('fecha_vencimiento', 'asc')
                ->get();
        //INICIO CON LA CANTIDAD DEL DETALLE
        $cantidadSolicitada = $ordenDetalle->cantidad_produccion;
    
        foreach ($lotes as $lote) {
            //SE OBTUVO LA CANTIDAD SOLICITADA DEL LOTE
            if ($cantidadSolicitada > 0) {
                //CANTIDAD LOGICA DEL LOTE ES IGUAL A LA CANTIDAD SOLICITADA
                $cantidadLogica = $lote->cantidad_logica;
                if ($cantidadLogica == $cantidadSolicitada) {
                    //CREAMOS EL NUEVO DETALLE
                    $coll = new Collection();
                    $coll->orden_produccion_detalle_id = $ordenDetalle->id;
                    $coll->lote_articulo_id =  $lote->id;
                    $coll->lote = $lote->lote;
                    $coll->fecha_vencimiento = $lote->fecha_vencimiento;
                    $coll->cantidad = $lote->cantidad_logica;
                    $nuevoDetalle->push( $coll);
                    //ACTUALIZAMOS EL LOTE
                    $lote->cantidad_logica = $lote->cantidad_logica - $cantidadSolicitada;
                    //REDUCIMOS LA CANTIDAD SOLICITADA
                    $cantidadSolicitada = 0;
                    $lote->update(); 
                }else{
                    
                    if ($lote->cantidad_logica < $cantidadSolicitada) {
                        //CREAMOS EL NUEVO DETALLE
                        $coll = new Collection();
                        $coll->orden_produccion_detalle_id = $ordenDetalle->id;
                        $coll->lote_articulo_id =  $lote->id;
                        $coll->lote = $lote->lote;
                        $coll->cantidad = $lote->cantidad_logica;
                        $coll->fecha_vencimiento = $lote->fecha_vencimiento;
                        $nuevoDetalle->push( $coll);
                        //REDUCIMOS LA CANTIDAD SOLICITADA
                        $cantidadSolicitada = $cantidadSolicitada - $lote->cantidad_logica;
                        //ACTUALIZAMOS EL LOTE
                        $lote->cantidad_logica = 0;
                        $lote->update(); 
                    }else{
                        if ($lote->cantidad_logica > $cantidadSolicitada) {
                            //CREAMOS EL NUEVO DETALLE
                            $coll = new Collection();
                            $coll->orden_produccion_detalle_id = $ordenDetalle->id;
                            $coll->lote_articulo_id =  $lote->id;
                            $coll->lote = $lote->lote;
                            $coll->fecha_vencimiento = $lote->fecha_vencimiento;
                            $coll->cantidad = $cantidadSolicitada;
                            $nuevoDetalle->push( $coll);
                            //ACTUALIZAMOS EL LOTE
                            $lote->cantidad_logica = $lote->cantidad_logica - $cantidadSolicitada;
                            //REDUCIMOS LA CANTIDAD SOLICITADA
                            $cantidadSolicitada = 0;
                            $lote->update(); 
                        }
                        
                    }

                }

            }

        }

        return $nuevoDetalle;
    }


    public function update(Request $request)
    {
        // dd($request);
        // DETALLE DE LA ORDEN DE PRODUCCION
        $detalle = OrdenDetalle::findOrFail($request->get('ordenDetalle_id'));
        $detalle->articulo_id = $request->get('articulo_id');
        $detalle->cantidad_produccion = $request->get('cantidadProduccion');
        $detalle->cantidad_produccion_completa = $request->get('cantidadProduccionCompleta');
        $detalle->cantidad_excedida = $request->get('cantidadExcedida');
        $detalle->update();
        //ELIMINAR MOVIMIENTOS
        $movimientosAlmacen = MovimientoAlmacen::where('orden_produccion_detalle_id',$detalle->id)
                            ->where('nota','DESTINO PRODUCCION')
                            ->where('articulo_id',$detalle->articulo->id)
                            ->where('movimiento','SALIDA')                                          
                            ->delete();
        //CREAR MOVIMIENTO - ALMACEN
        //CANTIDAD PRODUCCION
        $movimiento_canti_produccion = MovimientoAlmacen::create([
                                            'orden_produccion_detalle_id' =>  $detalle->id,
                                            'almacen_inicio_id' => $detalle->articulo->almacen->id,
                                            'almacen_final_id' => 3, //ALMACEN PRODUCCION
                                            'cantidad' =>  $detalle->cantidad_produccion,
                                            'nota' => 'DESTINO PRODUCCION',
                                            'observacion' => $detalle->articulo->descripcion.' - '.$detalle->articulo->codigo_fabrica,
                                            'usuario_id' =>  auth()->user()->id,
                                            'movimiento' => 'SALIDA',
                                            'articulo_id' => $detalle->articulo->id,
                                        ]);
        //CANTIDAD EXCEDENTE
        $movimiento_canti_excedida = MovimientoAlmacen::create([
                                            'orden_produccion_detalle_id' =>  $detalle->id,
                                            'almacen_inicio_id' => $detalle->articulo->almacen->id,
                                            'almacen_final_id' => 3, //ALMACEN PRODUCCION
                                            'cantidad' =>    $detalle->cantidad_excedida,
                                            'nota' => 'DESTINO PRODUCCION',
                                            'observacion' => 'EXCEDENTE',
                                            'usuario_id' =>  auth()->user()->id,
                                            'movimiento' => 'SALIDA',
                                            'articulo_id' => $detalle->articulo->id,
                                        ]);
        $cantidadProduccion = json_decode($request->get('cantidadProduccionLote'));
        $detalleLotes = OrdenDetalleLote::where('orden_produccion_detalle_id', $detalle->id)->where('tipo_cantidad','PRODUCCION')->get();

        //ELIMINAR MOVIMIENTOS
        $movimientoAlmacen =  MovimientoAlmacen::where('orden_produccion_detalle_id',$request->get('ordenDetalle_id'))
                                                ->where('nota','DEVOLUCION DE PROD')                                        
                                                ->get();
        if ($movimientoAlmacen->count() > 0) {
            MovimientoAlmacenDetalle::where('movimiento_almacen_id',$movimientoAlmacen->first()->id)->delete();
            $movimientoAlmacen->each->delete();
        }

        
        if ($cantidadProduccion) {
            // DEVOLUCION DE LOTES ARTICULOS
            foreach ($detalleLotes as $detalleLote) {
                $loteArticulo = LoteArticulo::findOrFail($detalleLote->lote_articulo_id);
                $cantidadTemp = $loteArticulo->cantidad + $detalleLote->cantidad;

                $loteArticulo->cantidad =  $cantidadTemp;
                $loteArticulo->cantidad_logica = $cantidadTemp;
                $loteArticulo->update();
                //ELIMINAR LAS DEVOLUCIONES
                $devoluciones = Devolucion::where('detalle_lote_id', $detalleLote->id)->delete();
                //ELIMINAR LOS DETALLES LOTES
                $detalleLote->delete();

            }
            
            foreach ($cantidadProduccion as $produccion) { 
                $lote = LoteArticulo::findOrFail($produccion->lote_id);
                $ordenLote = OrdenDetalleLote::create([
                                'orden_produccion_detalle_id' => $produccion->orden_produccion_detalle_id,
                                'lote_articulo_id' => $produccion->lote_id,
                                'cantidad' => $produccion->cantidad,
                                'tipo_cantidad' => 'PRODUCCION',
                            ]);
                $lote->cantidad =  $lote->cantidad - $produccion->cantidad;
                $lote->cantidad_logica = $lote->cantidad;
                $lote->update();

                //MOVIMIENTO ALMACEN - DETALLE (CANTIDAD PRODUCCION)
                MovimientoAlmacenDetalle::create([
                    'movimiento_almacen_id' => $movimiento_canti_produccion->id, //ID DEL MOVIMIENTO CANTIDAD
                    'articulo_id' => $ordenLote->loteArticulo->articulo->id,
                    'cantidad' => $ordenLote->cantidad,
                    'lote' => $ordenLote->loteArticulo->lote,
                    'fecha_vencimiento' =>  $ordenLote->loteArticulo->fecha_vencimiento,
                ]);

            }

        }else{
            // DEVOLUCION DE LOTES ARTICULOS
            foreach ($detalleLotes as $detalleLote) {
                $loteArticulo = LoteArticulo::findOrFail($detalleLote->lote_articulo_id);
                $cantidadTemp = $loteArticulo->cantidad + $detalleLote->cantidad;
                
                $loteArticulo->cantidad = $cantidadTemp;
                $loteArticulo->cantidad_logica = $cantidadTemp;
                $loteArticulo->update();
                //ELIMINAR LAS DEVOLUCIONES
                $devoluciones = Devolucion::where('detalle_lote_id', $detalleLote->id)->delete();
                //ELIMINAR LOS DETALLES LOTES
                $detalleLote->delete();
            }
        }

        $cantidadExcedida = json_decode($request->get('cantidadExcedidaLote'));
        $detalleLotes = OrdenDetalleLote::where('orden_produccion_detalle_id', $detalle->id)->where('tipo_cantidad','EXCEDIDA')->get();

        // ELIMINAR MOVIMIENTOS - ALMACEN
        $movimientoAlmacen = MovimientoAlmacen::where('orden_produccion_detalle_id',$request->get('ordenDetalle_id'))
                                                ->where('nota','MAL ESTADO')                                        
                                                ->get();
        if ($movimientoAlmacen->count() > 0) {
            MovimientoAlmacenDetalle::where('movimiento_almacen_id',$movimientoAlmacen->first()->id)->delete();
            $movimientoAlmacen->each->delete();
        }

        if ($cantidadExcedida) {
            foreach ($cantidadExcedida as $excedida) { 
                // DEVOLUCION DE LOTES ARTICULOS
                foreach ($detalleLotes as $detalleLote) {
                    $loteArticulo = LoteArticulo::findOrFail($detalleLote->lote_articulo_id);
                    $cantidadTemp = $loteArticulo->cantidad + $detalleLote->cantidad;

                    $loteArticulo->cantidad = $cantidadTemp;
                    $loteArticulo->cantidad_logica = $cantidadTemp;
                    $loteArticulo->update();
                    //ELIMINAR LAS DEVOLUCIONES
                    $devoluciones = Devolucion::where('detalle_lote_id', $detalleLote->id)->delete();
                    //ELIMINAR LOS DETALLES LOTES
                    $detalleLote->delete();
                }

                $lote = LoteArticulo::findOrFail($excedida->lote_id);
                $ordenLote = OrdenDetalleLote::create([
                    'orden_produccion_detalle_id' => $detalle->id,
                    'lote_articulo_id' => $excedida->lote_id,
                    'cantidad' => $excedida->cantidad,
                    'tipo_cantidad' => 'EXCEDIDA',
                ]);
                $lote->cantidad =  $lote->cantidad - $excedida->cantidad;
                $lote->cantidad_logica = $lote->cantidad;
                $lote->update();

                //MOVIMIENTO ALMACEN - DETALLE (CANTIDAD EXCEDIDA)
                MovimientoAlmacenDetalle::create([
                    'movimiento_almacen_id' => $movimiento_canti_excedida->id, //ID DEL MOVIMIENTO CANTIDAD EXCEDIDO
                    'articulo_id' => $ordenLote->loteArticulo->articulo->id,
                    'cantidad' => $ordenLote->cantidad,
                    'lote' => $ordenLote->loteArticulo->lote,
                    'fecha_vencimiento' =>  $ordenLote->loteArticulo->fecha_vencimiento,
                ]);

                
            }
        }else{
            // DEVOLUCION DE LOTES ARTICULOS
            foreach ($detalleLotes as $detalleLote) {
                $loteArticulo = LoteArticulo::findOrFail($detalleLote->lote_articulo_id);
                $cantidadTemp = $loteArticulo->cantidad + $detalleLote->cantidad;

                $loteArticulo->cantidad = $cantidadTemp;
                $loteArticulo->cantidad_logica =  $cantidadTemp;
                $loteArticulo->update();
                //ELIMINAR LAS DEVOLUCIONES
                $devoluciones = Devolucion::where('detalle_lote_id', $detalleLote->id)->delete();
                //ELIMINAR LOS DETALLES LOTES
                $detalleLote->delete();
            }
        }

        //CAMBIAR EL ESTADO DEL DETALLE A COMPLETADO CUANDO SE CREA LA DEVOLUCION
        $detalle->completado = '1';
        $detalle->update();
      
        $productoDetalles= ProductoDetalle::where('producto_id',$detalle->orden->producto_id)->where('estado','ACTIVO')->get();
        Session::flash('success','Devoluciones con cantidades 0.');
        return redirect()->route('produccion.orden.edit', 
            [
                'orden' => $detalle->orden,
                'productoDetalles' => $productoDetalles,
            ]
        )->with('modificar', 'success');
    }





    //POSIBLE CODIGO BASURA
    public function store(Request $request)
    {
        // ORDEN DE PRODUCCION
        $orden = new Orden();
        $orden->programacion_id = $request->get('programacion_aprobada_id');
        //PROGRAMACION APROBADA
        $programacion= Programacion_produccion::findOrFail($request->get('programacion_aprobada_id'));
        //PRODUCTO DE LA PROGRAMACION APROBADA
        $producto= Producto::findOrFail($programacion->producto_id);
        //DATOS DEL PRODUCTO
        $orden->producto_id = $programacion->producto_id;
        $orden->codigo_producto = $producto->codigo;
        $orden->descripcion_producto = $producto->nombre;
        //DATOS DE LA PROGRAMACION
        $orden->fecha_produccion = $programacion->fecha_produccion;
        $orden->cantidad = $programacion->cantidad_programada;
        $orden->save();

        //BUSCAR TODOS LOS DETALLES DE LA ORDEN DE PRODUCCION 
        $productoDetalles = ProductoDetalle::where('producto_id',$programacion->producto_id)->where('estado','ACTIVO')->get();
        //AGREGAMOS TODOS LOS ARTICULOS DE LA ORDEN AL DETALLE
        foreach ($productoDetalles as $productoDetalle) { 
            OrdenDetalle::create([
                'orden_id' => $orden->id,
                'articulo_id' => $productoDetalle->articulo_id,
                'cantidad_produccion' => $programacion->cantidad_programada * $productoDetalle->cantidad,
                'cantidad_produccion_completa' => $programacion->cantidad_programada * $productoDetalle->cantidad.' '.$productoDetalle->articulo->getMedida(),
                'cantidad_excedida' => $programacion->cantidad_programada * $productoDetalle->cantidad,
            ]);
        }

        // MODIFICAMOS EL DETALLE DE LA ORDEN DE PRODUCCION
        $detalle = OrdenDetalle::where('articulo_id', $request->get('articulo_id'))
                                ->where('orden_id', $orden->id)
                                ->first();
        $detalle->orden_id = $orden->id;
        $detalle->articulo_id = $request->get('articulo_id');
        $detalle->cantidad_produccion = $request->get('cantidadProduccion');
        $detalle->cantidad_produccion_completa = $request->get('cantidadProduccionCompleta');
        $detalle->cantidad_excedida = $request->get('cantidadExcedida');
        $detalle->completado = '1';
        $detalle->update();

        //AGREGAMOS LAS CANTIDADES AL DETALLE LOTE
        $cantidadProduccion = json_decode($request->get('cantidadProduccionLote'));

        if ($cantidadProduccion) {
            foreach ($cantidadProduccion as $produccion) { 
                $lote = LoteArticulo::findOrFail($produccion->lote_id);
                OrdenDetalleLote::create([
                    'orden_produccion_detalle_id' => $detalle->id,
                    'lote_articulo_id' => $produccion->lote_id,
                    'cantidad' => $produccion->cantidad,
                    'tipo_cantidad' => 'PRODUCCION',
                ]);

                $lote->cantidad =  $lote->cantidad - $produccion->cantidad;
                $lote->update();
            }
        }

        $cantidadExcedida = json_decode($request->get('cantidadExcedidaLote'));

        if ($cantidadExcedida) {
            foreach ($cantidadExcedida as $excedida) { 
                $lote = LoteArticulo::findOrFail($excedida->lote_id);
                OrdenDetalleLote::create([
                    'orden_produccion_detalle_id' => $detalle->id,
                    'lote_articulo_id' => $excedida->lote_id,
                    'cantidad' => $excedida->cantidad,
                    'tipo_cantidad' => 'EXCEDIDA',
                ]);
                $lote->cantidad =  $lote->cantidad - $excedida->cantidad;
                $lote->update();
            }
        }

        //CAMBIAR EL ESTADO DE LA PROGRAMACION DE PRODUCCION (NO PUEDA AGREGAR ORDEN DE PRODUCCION)
        $programacion->produccion = '1';
        $programacion->update();
        
        //RETORNAMOS A LA VISTA EDITAR PARA QUE SE SIGA INGRESANDO DETALLE A LA ORDEN

        $productoDetalles= ProductoDetalle::where('producto_id',$programacion->producto_id)->where('estado','ACTIVO')->get();
        return redirect()->route('produccion.orden.edit', 
            [
                'orden' => $orden,
                'productoDetalles' => $productoDetalles,
                'ordenDetalle' => $detalle,
            ]
        )->with('guardar', 'success');
    }

    //LOTES - ARTICULO PARA BUSQUEDA
    public function getLotArticle($articulo_id)
    {
        return datatables()->query(
            DB::table('lote_articulos')
            ->join('articulos','lote_articulos.articulo_id','=','articulos.id')
            ->select('lote_articulos.*',DB::raw('DATE_FORMAT(lote_articulos.fecha_vencimiento, "%d/%m/%Y") as fecha_venci'))
            ->where('lote_articulos.cantidad_logica','>',0) 
            ->where('lote_articulos.estado','1') 
            ->where('lote_articulos.articulo_id',$articulo_id) 
            ->orderBy('lote_articulos.fecha_vencimiento','ASC')  
            ->where('articulos.estado','ACTIVO')
        )->toJson();
    }

    //CAMBIAR CANTIDAD LOGICA DEL LOTE ARTIculo
    public function quantity(Request $request)
    {
      
        $data = $request->all();
        $lote_id = $data['lote_id'];
        $cantidad = $data['cantidad'];
        $condicion = $data['condicion'];
        $mensaje = '';
        $lote = LoteArticulo::findOrFail($lote_id);
        //DISMINUIR
        if ($lote->cantidad_logica >= $cantidad && $condicion == '1' ) {
            $nuevaCantidad = $lote->cantidad_logica - $cantidad;
            $lote->cantidad_logica = $nuevaCantidad;
            $lote->update();
            $mensaje = 'Cantidad aceptada';
        }
        //AUMENTAR
        if ($condicion == '0' ) {
            $nuevaCantidad = $lote->cantidad_logica + $cantidad;
            $lote->cantidad_logica = $nuevaCantidad;
            $lote->update();
            $mensaje = 'Cantidad regresada';
        }

        return $mensaje;
    }

    //DEVOLVER CANTIDAD LOGICA AL CERRAR VENTANA
    public function returnQuantity(Request $request)
    {
   
        $data = $request->all();
        $cantidades = $data['cantidades'];
        $articulosJSON = $cantidades;
        $productotabla = json_decode($articulosJSON);
        $mensaje = '';
        foreach ($productotabla as $detalle) {
            //DEVOLVEMOS CANTIDAD AL LOTE Y AL LOTE LOGICO
            $lote = LoteArticulo::findOrFail($detalle->lote_id);
            $lote->cantidad_logica = $lote->cantidad_logica + $detalle->cantidad;
            $lote->cantidad =  $lote->cantidad_logica;
            $lote->estado = '1';
            $lote->update();
            $mensaje = 'Cantidad devuelta';
        };

        return $mensaje;
    
    }


}
