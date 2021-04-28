<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Almacenes\Almacen;
use Faker\Generator as Faker;

$factory->define(Almacen::class, function (Faker $faker) {
    return [
        'descripcion' => $faker->name,
        'ubicacion'=> $faker->name,
        'estado' => 'ACTIVO',
    ];
});
