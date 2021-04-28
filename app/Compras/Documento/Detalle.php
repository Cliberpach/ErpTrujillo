<?php

namespace App\Compras\Documento;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Compras\Articulo;
use App\Compras\LoteArticulo;
use Illuminate\Support\Facades\Auth;
//MOVIMIENTOS
use App\Movimientos\MovimientoAlmacen;
use App\Movimientos\MovimientoAlmacenDetalle;

class Detalle extends Model
{
    protected $table = 'compra_documento_detalles';
    public $timestamps = true;
    protected $fillable = [
        'id',
        'documento_id',
        'articulo_id',
        'codigo_articulo',
        'descripcion_articulo',
        'presentacion_articulo',
        'medida_articulo',
        'cantidad',
        'precio',
        'costo_flete',
        'lote',
        'fecha_vencimiento'
    ];

    public function documento()
    {
        return $this->belongsTo('App\Compras\Documento\Documento');
    }
    public function articulo()
    {
        return $this->belongsTo('App\Compras\Articulo');
    }

    public function fechaFormateada()
    {
        $fecha = Carbon::createFromFormat('Y-m-d',$this->fecha_vencimiento)->format('d/m/Y');
        return $fecha;
    }

    protected static function booted() 
    {
        static::created(function(Detalle $detalle){
            //CREAR LOTE ARTICULO
            $lote = new LoteArticulo(); 
            $lote->detalle_id = $detalle->id;
            $lote->lote = $detalle->lote;
            $lote->articulo_id = $detalle->articulo_id;
            $lote->codigo_articulo = $detalle->codigo_articulo;
            $lote->descripcion_articulo = $detalle->descripcion_articulo;
            $lote->cantidad = $detalle->cantidad;
            $lote->cantidad_logica = $detalle->cantidad;
            $lote->fecha_vencimiento = $detalle->fecha_vencimiento;
            $lote->estado = '1';
            $lote->save();

            //MOVIMIENTO
            $articulo = Articulo::findOrFail($detalle->articulo->id);
            $movimiento = new MovimientoAlmacen(); 
            $movimiento->almacen_final_id = $detalle->articulo->almacen->id;
            $movimiento->cantidad = $detalle->cantidad;
            $movimiento->nota = 'COMPRA';
            $movimiento->observacion = $articulo->codigo_fabrica.' '.$articulo->descripcion;
            $movimiento->usuario_id = auth()->user()->id;
            $movimiento->movimiento = 'INGRESO';
            $movimiento->articulo_id = $detalle->articulo_id;
            $movimiento->documento_compra_id = $detalle->documento_id; //DOCUMENTO DE COMPRA
            $movimiento->save();

            //MOVIMIENTO DETALLE
            $detalleAlmacen = new MovimientoAlmacenDetalle();
            $detalleAlmacen->movimiento_almacen_id = $movimiento->id; 
            $detalleAlmacen->articulo_id = $articulo->id;
            $detalleAlmacen->cantidad = $detalle->cantidad;
            $detalleAlmacen->lote = $detalle->lote;
            $detalleAlmacen->fecha_vencimiento = $detalle->fecha_vencimiento;
            $detalleAlmacen->estado = '1';
            $detalleAlmacen->save();

        });

        static::deleted(function(Detalle $detalle){
            //ANULAR LOTE ARTICULO
            $lote = LoteArticulo::where('detalle_id', $detalle->id)->first(); 
            $lote->estado = '0';
            $lote->update();
        });


    }
}
