<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comprobante;
use Faker\Generator as Faker;

$factory->define(Comprobante::class, function (Faker $faker) {
    return [
        'fecha' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'hora' => $faker->time($format = 'H:i:s', $max = 'now'),
        'tipo' => $faker->randomElement(['Venta', 'Compra']),
        'total' => $faker->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 10),
    ];
});