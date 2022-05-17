<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\InvoicePayment;
use Faker\Generator as Faker;

$factory->define(InvoicePayment::class, function (Faker $faker) {

    return [
        'ref_number' => $faker->word,
        'date_paid' => $faker->date('Y-m-d H:i:s'),
        'amount' => $faker->randomDigitNotNull,
        'sacco_id' => $faker->randomDigitNotNull,
        'deleted_at' => $faker->date('Y-m-d H:i:s'),
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
