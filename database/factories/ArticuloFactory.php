<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Articulo;
use App\Rubro;
use Faker\Generator as Faker;

$factory->define(Articulo::class, function (Faker $faker) {
    return [
        'nombre' => $faker->name,
        'rubro_id' => Rubro::all()->random()->id,
        'stock_min' => $faker->numberBetween($min = 1000, $max = 9000),
        'stock_max' => $faker->numberBetween($min = 1000, $max = 9000),
        'precio' => $faker->randomFloat($nbMaxDecimals = 2, $min = 1, $max = NULL),
        'fecha_venc' => $faker->date($format = 'Y-m-d', $max = 'now'),
    ];
});
