<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Customer;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'ruc' => $faker->word,
        'manager' => $faker->word,
        'number_phone' => $faker->word,
        'sector_id' => factory(\App\Models\Sector::class),
        'user_id' => factory(\App\Models\User::class),
    ];
});
