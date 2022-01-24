<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ComprobanteDetalle;
use App\Comprobante;
use App\Articulo;
use Faker\Generator as Faker;

$factory->define(ComprobanteDetalle::class, function (Faker $faker) {
    return [
        'comprobante_id' => Comprobante::all()->random()->id,
        'articulo_id' => Articulo::all()->random()->id,
        'cantidad' => $faker->numberBetween($min = 1, $max = 10),
        'precio' => $faker->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 10),
    ];
});