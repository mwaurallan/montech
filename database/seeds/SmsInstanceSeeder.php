<?php

use Illuminate\Database\Seeder;

class SmsInstanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $instances = [
            'UserRegistered',
            'MpesaPaymentReceived'
        ];

        foreach ($instances as $instance){
            $inst = \App\Models\SmsInstance::firstOrCreate([
                'instance' => $instance
            ]);
        }
    }
}
