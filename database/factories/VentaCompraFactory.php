<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\VentaCompra;
use App\Articulo;
use Faker\Generator as Faker;

$factory->define(VentaCompra::class, function (Faker $faker) {
    return [
        'articulo_id' => Articulo::all()->random()->id,
        'cantidad' => $faker->numberBetween($min = 1, $max = 5),
        'precio' => $faker->randomFloat($nbMaxDecimals = 2, $min = 1, $max = NULL),
    ];
});
