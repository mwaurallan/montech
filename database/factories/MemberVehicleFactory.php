<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\MemberVehicle;
use Faker\Generator as Faker;

$factory->define(MemberVehicle::class, function (Faker $faker) {

    return [
        'member_id' => $faker->randomDigitNotNull,
        'vehicle_id' => $faker->word,
        'status' => $faker->word,
        'deleted_at' => $faker->date('Y-m-d H:i:s'),
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
