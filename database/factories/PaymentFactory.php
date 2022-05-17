<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Payment;
use Faker\Generator as Faker;

$factory->define(Payment::class, function (Faker $faker) {

    return [
        'payment_mode' => $faker->word,
        'source' => $faker->word,
        'ref_number' => $faker->word,
        'amount' => $faker->randomDigitNotNull,
        'paybill' => $faker->word,
        'phone_number' => $faker->word,
        'bill_ref_number' => $faker->word,
        'trans_id' => $faker->word,
        'trans_time' => $faker->date('Y-m-d H:i:s'),
        'first_name' => $faker->word,
        'middle_name' => $faker->word,
        'last_name' => $faker->word,
        'received_on' => $faker->date('Y-m-d H:i:s'),
        'status' => $faker->word,
        'deleted_at' => $faker->date('Y-m-d H:i:s'),
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
