<?php

namespace App\Compras;

use Illuminate\Database\Eloquent\Model;

class Detalle extends Model
{
    protected $table = 'detalle_ordenes';
    public $timestamps = true;
    protected $fillable = [
        'orden_id',
        'articulo_id',
        'cantidad',
        'precio',
    ];

    public function orden()
    {
        return $this->belongsTo('App\Compras\Orden');
    }
    public function articulo()
    {
        return $this->belongsTo('App\Compras\Articulo');
    }
}
