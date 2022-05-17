<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Passenger;
use Faker\Generator as Faker;

$factory->define(Passenger::class, function (Faker $faker) {

    return [
        'first_name' => $faker->word,
        'middle_name' => $faker->word,
        'last_name' => $faker->word,
        'phone_number' => $faker->word,
        'id_number' => $faker->word,
        'deleted_at' => $faker->date('Y-m-d H:i:s'),
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
