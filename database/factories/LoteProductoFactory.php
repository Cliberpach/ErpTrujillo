<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Almacenes\LoteProducto;
use Faker\Generator as Faker;

$factory->define(LoteProducto::class, function (Faker $faker) {
    return [
        'codigo' => $faker->unique()->randomNumber,
        'producto_id'=> 1,
        'cantidad' => $faker->randomNumber,
        'fecha_vencimiento'=> $faker->date,
        'estado' => '1',
    ];
});
