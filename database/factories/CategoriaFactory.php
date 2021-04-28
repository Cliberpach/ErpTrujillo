<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Compras\Categoria;
use Faker\Generator as Faker;

$factory->define(Categoria::class, function (Faker $faker) {
    return [
        'descripcion' => $faker->name,
        'estado' => 'ACTIVO',
    ];
});
