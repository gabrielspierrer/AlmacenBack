<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Articulo;
use App\Rubro;
use Faker\Generator as Faker;

$factory->define(Articulo::class, function (Faker $faker) {
    return [
        'nombre' => $faker->name,
        'rubro_id' => Rubro::all()->random()->id,
        'stock' => $faker->numberBetween($min = 0, $max = 1000),
        'precio' => $faker->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 10),
    ];
});