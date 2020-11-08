<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Sector;
use Faker\Generator as Faker;

$factory->define(Sector::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text,
    ];
});
