<?php

namespace App\Movimientos;

use Illuminate\Database\Eloquent\Model;

class MovimientoAlmacenDetalle extends Model
{
    protected $table = 'movimiento_almacenes_detalles';
    public $timestamps = true;
    protected $fillable = [
            'movimiento_almacen_id',
            'articulo_id',
            'cantidad',
            'lote',
            'fecha_vencimiento',
            'estado',
        ];
}
