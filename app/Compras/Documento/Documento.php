<?php

namespace App\Compras\Documento;

use Illuminate\Database\Eloquent\Model;
use App\Compras\Documento\Detalle;
use App\Compras\Articulo;
use App\Movimientos\MovimientoAlmacen;

class Documento extends Model
{
    protected $table = 'compra_documentos';
    public $timestamps = true;
    protected $fillable = [
            'id',
            'fecha_emision',
            'fecha_entrega',
            'empresa_id',
            'proveedor_id',
            'modo_compra',
            'moneda',
            'observacion',
            'igv',
            'igv_check',
            'tipo_cambio',
            
            'tipo_compra',
            'orden_compra',
            'tipo_pago',

            'sub_total',
            'total_igv',
            'total',

        
            'estado',
            'enviado',
            'usuario_id',

        ];

    public function empresa()
    {
        return $this->belongsTo('App\Mantenimiento\Empresa\Empresa');
    }
    public function proveedor()
    {
        return $this->belongsTo('App\Compras\Proveedor');
    }
    public function usuario()
    {
        return $this->belongsTo('App\User','usuario_id');
    }    
 
}
