<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\LoanRepaymetReceipt;
use Faker\Generator as Faker;

$factory->define(LoanRepaymetReceipt::class, function (Faker $faker) {

    return [
        'borrower_id' => $faker->randomDigitNotNull,
        'date' => $faker->word,
        'vehicle_id' => $faker->randomDigitNotNull,
        'receipt' => $faker->word,
        'amount' => $faker->randomDigitNotNull,
        'user_id' => $faker->randomDigitNotNull,
        'status' => $faker->word,
        'deleted_at' => $faker->date('Y-m-d H:i:s'),
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
