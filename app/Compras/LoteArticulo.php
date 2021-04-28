<?php

namespace App\Compras;

use Illuminate\Database\Eloquent\Model;
use App\Compras\Articulo;
class LoteArticulo extends Model
{
    protected $table = 'lote_articulos';
    protected $fillable = [
        'detalle_id',
        'lote',
        'articulo_id',
        'codigo_articulo',
        'descripcion_articulo',
        'cantidad',
        'cantidad_logica',
        'fecha_vencimiento',
        'estado'
    ];
    public $timestamps = true;

    public function articulo()
    {
        return $this->belongsTo('App\Compras\Articulo','articulo_id');
    }

    //EVENTO AL CREAR - ACTUALIZAR STOCK DEL ARTICULO
    protected static function booted() 
    {
        static::creating(function(LoteArticulo $lote){
            //ACTUALIZAR EL STOCK DEL ARTICULO
            $articulo = Articulo::findOrFail($lote->articulo_id);
            $articulo->stock = $articulo->stock + $lote->cantidad;
            $articulo->update();
        });
    }

}
