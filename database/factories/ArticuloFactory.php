<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Compras\Articulo;
use Faker\Generator as Faker;

$factory->define(Articulo::class, function (Faker $faker) {
    return [
        'codigo_fabrica' => $faker->unique()->randomNumber,
        'presentacion' => 'KILOGRAMO',
        'descripcion' => $faker->name,
        'stock_min'=> $faker->randomNumber(),
        'categoria_id' => factory(App\Compras\Categoria::class),
        'almacen_id' => factory(App\Almacenes\Almacen::class),
        'precio_compra' => $faker->randomFloat(2, 10, 100),
        'estado'=> 'ACTIVO',
    ];
});
