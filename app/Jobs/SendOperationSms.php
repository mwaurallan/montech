<?php

namespace App\Jobs;

use App\Helpers\GeneralHelper;
use App\Models\OtherIncome;
use App\Models\OtherIncomeType;
use App\Models\Setting;
use App\Models\Sms;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendOperationSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if(\App\Models\Setting::where('setting_key','company_name')->first()->setting_value == 'Transnomics Sacco'){
            $otherIncomeType = OtherIncomeType::where('name','Operation')->first();
            $todayOp = $incomes = OtherIncome::whereBetween('date',[Carbon::today()->startOfDay(),Carbon::today()->endOfDay()])
                ->where('other_income_type_id',$otherIncomeType->id?? 0)
                ->sum('amount');

            $message = 'Total Operation collected on '.Carbon::today()->format('d/m/Y').' is Ksh. '.number_format($todayOp).'. Transnomics Sacco.';
            $phones = [
                '0722261598',
                '0722702690',
                '0720840130',
                '0715862938'
            ];

            foreach ($phones as $phone){
                $sms = Sms::create([
                'user_id' => 1,
                    'message' => $message,
                    'recipients' => 1,
                    'send_to' => $phone,
                    'sacco_id' => 1,
                    'branch_id' => 1,
                    'status' => 'SENT',
                    'sender' => 'VOOMSMS',
                    'sent'=> true
                ]);
                GeneralHelper::send_sms($phone,$message);
            }
        }

    }
}
