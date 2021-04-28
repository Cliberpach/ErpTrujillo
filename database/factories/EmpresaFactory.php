<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Mantenimiento\Empresa;
use Faker\Generator as Faker;

$factory->define(Empresa::class, function (Faker $faker) {
    return [
        'ruc' => $faker->numberBetween($min = 10000000000, $max = 99999999999), 
        'razon_social' =>  $faker->name,
        'razon_social_abreviada' =>  $faker->name,
        'direccion_fiscal' =>  $faker->name,
        'direccion_llegada' =>  $faker->name,
        'dni_representante' =>  $faker->numberBetween(10000000,99999999),
        'nombre_representante' =>  $faker->name,
        'num_asiento' =>  $faker->numberBetween(500,10000),
        'num_partida' =>  $faker->numberBetween(500,10000),
        'activo' =>  '1',
        'estado' => 'ACTIVO'

    ];
});
