<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Sms;
use Faker\Generator as Faker;

$factory->define(Sms::class, function (Faker $faker) {

    return [
        'user_id' => $faker->randomDigitNotNull,
        'message' => $faker->text,
        'recipients' => $faker->randomDigitNotNull,
        'send_to' => $faker->text,
        'notes' => $faker->text,
        'gateway' => $faker->word,
        'sacco_id' => $faker->randomDigitNotNull,
        'deleted_at' => $faker->date('Y-m-d H:i:s'),
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'branch_id' => $faker->randomDigitNotNull,
        'name' => $faker->word,
        'status' => $faker->word,
        'reason' => $faker->word,
        'sender' => $faker->word,
        'delivery_checked' => $faker->word,
        'sent' => $faker->word
    ];
});
