<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Manifest;
use Faker\Generator as Faker;

$factory->define(Manifest::class, function (Faker $faker) {
    return [
        'code' => $faker->word,
        'create_date' => $faker->date(),
        'pick_up_date' => $faker->date(),
        'file' => $faker->text,
        'document_type_id' => factory(\App\Models\DocumentType::class),
        'address_id' => factory(\App\Models\Address::class),
        'user_id' => factory(\App\Models\User::class),
    ];
});
