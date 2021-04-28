<?php

namespace App\Movimientos;

use Illuminate\Database\Eloquent\Model;

class MovimientoAlmacen extends Model
{
    protected $table = 'movimiento_almacenes';
    public $timestamps = true;
    protected $fillable = [
            'orden_produccion_detalle_id',
            'almacen_inicio_id',
            'almacen_final_id',
            'cantidad',
            'nota',
            'observacion',
            'usuario_id',
            'movimiento',
            'articulo_id',
            'documento_compra_id',
            'solicitud_id',
        ];
}
