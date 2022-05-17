<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\FieldSavingTransaction;
use Faker\Generator as Faker;

$factory->define(FieldSavingTransaction::class, function (Faker $faker) {

    return [
        'user_id' => $faker->randomDigitNotNull,
        'borrower_id' => $faker->randomDigitNotNull,
        'savings_id' => $faker->randomDigitNotNull,
        'amount' => $faker->word,
        'vehicle_id' => $faker->word,
        'type' => $faker->word,
        'system_interest' => $faker->word,
        'date' => $faker->word,
        'time' => $faker->word,
        'year' => $faker->word,
        'month' => $faker->word,
        'notes' => $faker->text,
        'sacco_id' => $faker->randomDigitNotNull,
        'deleted_at' => $faker->date('Y-m-d H:i:s'),
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
