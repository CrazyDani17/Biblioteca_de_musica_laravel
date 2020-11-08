<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Document_type;
use Faker\Generator as Faker;

$factory->define(DocumentType::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text,
    ];
});
