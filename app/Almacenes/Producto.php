<?php

namespace App\Almacenes;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'familia_id',
        'sub_familia_id',
        'medida',
        'stock',
        'stock_minimo',
        'precio_venta_minimo',
        'precio_venta_maximo',
        'igv',
        'estado',
        'codigo_barra',
        'linea_comercial',
        'peso_producto'
    ];
    protected $casts = [
        'igv' => 'boolean'
    ];

    public function familia()
    {
        return $this->belongsTo('App\Almacenes\Familia');
    }

    public function sub_familia()
    {
        return $this->belongsTo('App\Almacenes\SubFamilia');
    }

    public function detalles()
    {
        return $this->hasMany('App\Almacenes\ProductoDetalle');
    }

    public function getDescripcionCompleta()
    {
        return $this->codigo.' - '.$this->nombre;
    }

    public function tabladetalle()
    {
        return $this->belongsTo('App\Mantenimiento\Tabla\detalle','medida');
    }
    
    public function getMedida(): string
    {
        $medida = unidad_medida()->where('id', $this->medida)->first();
        if (is_null($medida))
            return "-";
        else
            return $medida->simbolo;
    }

    public function medidaCompleta(): string
    {
        $medida = unidad_medida()->where('id', $this->medida)->first();
        if (is_null($medida))
            return "-";
        else
            return $medida->simbolo.' - '.$medida->descripcion;
    }
}
