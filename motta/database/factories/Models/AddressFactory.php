<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Address;
use Faker\Generator as Faker;

$factory->define(Address::class, function (Faker $faker) {
    return [
        'customer_id' => factory(\App\Models\Customer::class),
        'address' => $faker->word,
    ];
});
