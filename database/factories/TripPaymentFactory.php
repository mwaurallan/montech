<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\TripPayment;
use Faker\Generator as Faker;

$factory->define(TripPayment::class, function (Faker $faker) {

    return [
        'trip_id' => $faker->word,
        'payment_id' => $faker->word,
        'passenger_id' => $faker->word,
        'date' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s'),
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
