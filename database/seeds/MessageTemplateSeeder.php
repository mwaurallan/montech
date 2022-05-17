<?php

use Illuminate\Database\Seeder;

class MessageTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $templates = [
            [
                'event' => 'MemberSavings',
                'message' => 'Dear @member, we are in receipt of @products a total of Ksh. @total on @date.'
            ],
            [
                'event' => memberRegistered,
                'message' => 'Dear @member, we are glad to welcome you to @sacconame .'
            ],
            [
                'event' => 'MpesaPaymentReceived',
                'message' => 'Dear @member, we are in receipt of @amount reference @reference on @date, thank you.'
            ],
            [
                'event' => 'SavingsWithdraw',
                'message' => 'Dear @member, @amount has been transferred from @ account to @account .'
            ],
            [
                'event' => mpesaPaymentProcessed,
                'message' => 'Dear @member, your savings of kshs. @amount sent on @date has been received. New balance at RGS Sacco is kshs. @balance.'
            ],

        ];

        foreach ($templates as $template){
            print $ms = \App\Models\MessageTemplate::where('event',$template['event'])->first();

            if(is_null($ms)){
                $t = \App\Models\MessageTemplate::create([
                    'event' => $template['event'],
                    'message' => $template['message'],
                    'status' => false
            ]);
            }

        }
    }
}
