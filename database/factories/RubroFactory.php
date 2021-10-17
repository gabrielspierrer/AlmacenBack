<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Rubro;
use Faker\Generator as Faker;

$factory->define(Rubro::class, function (Faker $faker) {
    return [
        'nombre' => $faker->name,
    ];
});
