<?php

namespace App\Almacenes;

use App\Almacenes\Producto;
use Illuminate\Database\Eloquent\Model;

use App\Produccion\OrdenDetalle;
use App\Compras\Articulo;

class LoteProducto extends Model
{
    protected $table = 'lote_productos';
    protected $fillable = [
        'orden_id',

        'codigo',
        'producto_id',
        'codigo_producto',
        'descripcion_producto',
        'cantidad',
        'cantidad_logica',
        
        'fecha_vencimiento',
        'fecha_entrega',
        'observacion',

        'confor_almacen',
        'confor_produccion',

        'estado'
    ];
    public $timestamps = true;

    public function producto()
    {
        return $this->belongsTo('App\Almacenes\Producto','producto_id');
    }

    //EVENTO AL CREAR Y AL MODIFICAR
    protected static function booted()
    {
        static::saved(function(LoteProducto $loteProducto){
          
            if ($loteProducto->confor_almacen != null && $loteProducto->confor_produccion != null) {
                //RECORRER LOTE - PRODUCTO Y LA SUMA
                $cantidadProductos = LoteProducto::where('estado','1')->where('producto_id',$loteProducto->producto_id)->sum('cantidad');
                //ACTUALIZAR EL STOCK DEL PRODUCTO
                $producto = Producto::findOrFail($loteProducto->producto_id);
                $producto->stock = $cantidadProductos;
                $producto->update();

                $detalles = OrdenDetalle::where('orden_id', $loteProducto->orden_id)->get();
                foreach ($detalles as $detalle) {
        
                    if ($detalle->cantidad_devuelta_correcta) {
                        $correcto = $detalle->cantidad_devuelta_correcta;
                    }else{
                        $correcto = 0;
                    }
                    $nuevoStock = ($detalle->productoDetalle->articulo->stock - $detalle->cantidad_entregada) + $correcto; 
                    $articulo = Articulo::findOrFail($detalle->productoDetalle->articulo->id);
                    $articulo->stock =  $nuevoStock;
                    $articulo->update();
                    
                }
            }
        });
    }



}
