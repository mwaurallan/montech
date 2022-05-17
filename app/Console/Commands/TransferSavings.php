<?php

namespace App\Console\Commands;

use App\Helpers\GeneralHelper;
use App\Models\Borrower;
use App\Models\BorrowerGroupMember;
use App\Models\JournalEntry;
use App\Models\OtherIncome;
use App\Models\Saving;
use App\Models\SavingProduct;
use App\Models\SavingsProductCharge;
use App\Models\SavingTransaction;
use Carbon\Carbon;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TransferSavings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transfer:savings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //get members
        $borrowers = Borrower::all();
//        $borrowers = Borrower::where('id',478)->get();
        $savingProduct = SavingProduct::where('name','Savings')->first();
        $shares = SavingProduct::where('name','Shares')->first();
        $bar = $this->output->createProgressBar(count($borrowers));
        $bar->start();
        if(count($borrowers)){
            foreach ($borrowers as $borrower){
                //check whether they have savings
                $savingAccount = Saving::where('borrower_id',$borrower->id)
                    ->where('savings_product_id',$savingPId = $savingProduct->id ?? 1)
                    ->first();
                if(!is_null($savingAccount)){
                    //get saving account balance
                    $balance = GeneralHelper::savings_account_balance($savingAccount->id);

                    DB::transaction(function()use ($balance,$borrower,$savingAccount,$shares){
                        if($balance > 0){
                            //check of this member has contributed registration fees
                            $regFee = OtherIncome::where('borrower_id',$borrower->id)
                                ->where('other_income_type_id',1)
                                ->first();
                            if(is_null($regFee)){
                                //check if member is in any group
                                $borrowerGroupMember = BorrowerGroupMember::where('borrower_id',$borrower->id)->first();
                                if(is_null($borrowerGroupMember)){
                                    $amountToDeduct = 500;
                                }else{
                                    $amountToDeduct = 1000;
                                }
                                if($balance >= $amountToDeduct){
                                    //add registration fee

                                    $other_income = new OtherIncome();
                                    $other_income->other_income_type_id = 1;
                                    $other_income->account_id = 1;
                                    $other_income->amount = $amountToDeduct;
                                    $other_income->notes = $borrower->getFullNameAttribute();
                                    $other_income->date = Carbon::now();
                                    $other_income->borrower_id = $borrower->id;
                                    $other_income->branch_id = $borrower->branch_id;
                                    $other_income->sacco_id = 1;
                                    $other_income->user_id = 1;
                                    $date = explode('-', Carbon::today()->format('Y-m-d'));
                                    $other_income->year = $date[0];
                                    $other_income->month = $date[1];
                                    $other_income->save();
                                    $balance = $balance - $amountToDeduct;
//                                    print $balance;die;
                                    $this->transfer($borrower,$savingAccount,'withdrawal',$amountToDeduct,"Registration Fee");

                                }
                            }
                            $input['date'] = Carbon::now();
                            $input['time'] = Carbon::parse($input['date'])->toTimeString();
                            $input['year'] = Carbon::parse($input['date'])->year;
                            $input['month'] = Carbon::parse($input['date'])->month;
//                            print 'here';
                            if($balance > 0){
                                //shares account
                                $sharesAccount = Saving::where('borrower_id',$borrower->id)
                                    ->where('savings_product_id',$shareId = $shares->id ?? 1)
                                    ->first();
//                                print_r($sharesAccount);die;


                                //create shares account if it doesnt exist
                                if(is_null($sharesAccount)){
                                    $sharesAccount = Saving::create([
                                        'user_id' => 1,
                                        'borrower_id' => $borrower->id,
                                        'savings_product_id' => $shareId,
                                        'date' => $input['date'],
                                        'status' => 'active',
                                        'year' => $input['year'],
                                        'month' => $input['month'],
                                        'approved_date' => $input['date'],
                                        'sacco_id' => 1,
                                        'branch_id' => 1
                                    ]);
                                }
//                                print 'here';
                                $sharesBalance = GeneralHelper::savings_account_balance($sharesAccount->id);
//                                $this->info($sharesBalance);
//                                die;

                                if($sharesBalance < 2000){
                                    $shareDeficit = 2000 - $sharesBalance;

                                    if($balance >= $shareDeficit){
                                        //withdraw  share deficit from savings and deposit to share
                                        //withdraw from savings
                                        $this->transfer($borrower,$savingAccount,'withdrawal',$shareDeficit);
                                        //deposit to shares
                                        $this->transfer($borrower,$sharesAccount,'deposit',$shareDeficit);

                                    }else{
                                        // withdraw  balance
                                        //withdraw from savings
                                        $this->transfer($borrower,$savingAccount,'withdrawal',$balance);
                                        //deposit to shares
                                        $this->transfer($borrower,$sharesAccount,'deposit',$balance);
                                    }
                                }
                            }

                        }
                    });

                }
                $bar->advance();
            }
        }
        $bar->finish();
    }

    public function transfer($borrower,$saving,$type,$amount,$rFee = null){
        $receipt = '';
        if(!is_null($rFee)){
            $receipt = 'Registration Fee';
        }else{
            if($type == 'deposit'){
                $receipt = 'Transferred from savings';
            }else{
                $receipt = 'Transferred to shares';
            }
        }
        $input['date'] = Carbon::now();
        $input['time'] = Carbon::parse($input['date'])->toTimeString();
        $input['year'] = Carbon::parse($input['date'])->year;
        $input['month'] = Carbon::parse($input['date'])->month;
        $savings_transaction = new SavingTransaction();
        $savings_transaction->user_id = 1;
        $savings_transaction->borrower_id = $borrower->id;
        $savings_transaction->sacco_id = $borrower->sacco_id;
        $savings_transaction->branch_id = $borrower->branch_id;
        $savings_transaction->payment_method_id = 1;
        $savings_transaction->receipt = $receipt;
        $savings_transaction->savings_id = $saving->id;
        $savings_transaction->type = 'transfer_savings';
        $savings_transaction->reversible = 0;
        $savings_transaction->date = $input['date'];
        $savings_transaction->amount = $amount;
        $savings_transaction->year = $input['year'];
        $savings_transaction->month = $input['month'];
        $savings_transaction->notes = "Transferred ".(($type == 'deposit')? 'from savings': 'to shares');
        if ($type == "withdrawal") {
            $savings_transaction->debit = $amount;
        }
        if ($type == "deposit") {
            $savings_transaction->credit = $amount;
        }
        $savings_transaction->save();
        //make journal transactions
        if ($type == "deposit") {
            if (!empty($saving->savings_product->chart_reference)) {
                $journal = new JournalEntry();
                $journal->user_id = 1;
                $journal->account_id = $saving->savings_product->chart_reference->id;
                $journal->branch_id = $savings_transaction->branch_id;
                $journal->sacco_id = $savings_transaction->sacco_id;
                $journal->date = $input['date'];
                $journal->year = $input['year'];
                $journal->month = $input['month'];
                $journal->borrower_id = $savings_transaction->borrower_id;
                $journal->transaction_type = 'deposit';
                $journal->name = "Deposit";
                $journal->savings_id = $saving->id;
                $journal->debit = $amount;
                $journal->reference = $savings_transaction->id;
                $journal->save();
            }
            if (!empty($saving->savings_product->chart_control)) {
                $journal = new JournalEntry();
                $journal->user_id = 1;
                $journal->account_id = $saving->savings_product->chart_control->id;
                $journal->branch_id = $savings_transaction->branch_id;
                $journal->sacco_id = $savings_transaction->sacco_id;
                $journal->date = $input['date'];
                $journal->year = $input['year'];
                $journal->month = $input['month'];
                $journal->borrower_id = $savings_transaction->borrower_id;
                $journal->transaction_type = 'deposit';
                $journal->name = "Deposit";
                $journal->savings_id = $saving->id;
                $journal->credit = $amount;
                $journal->reference = $savings_transaction->id;
                $journal->save();
            }
        }
        if ($type == "withdrawal") {

            if (!empty($saving->savings_product->chart_reference)) {
                $journal = new JournalEntry();
                $journal->user_id = 1;
                $journal->account_id = $saving->savings_product->chart_reference->id;
                $journal->branch_id = $savings_transaction->branch_id;
                $journal->sacco_id = $savings_transaction->sacco_id;
                $journal->date = $input['date'];
                $journal->year = $input['year'];
                $journal->month = $input['month'];
                $journal->borrower_id = $savings_transaction->borrower_id;
                $journal->transaction_type = 'withdrawal';
                $journal->name = "Withdrawal";
                $journal->savings_id = $saving->id;
                $journal->credit = $amount;
                $journal->reference = $savings_transaction->id;
                $journal->save();
            }
            if (!empty($saving->savings_product->chart_control)) {
                $journal = new JournalEntry();
                $journal->user_id = 1;
                $journal->account_id = $saving->savings_product->chart_control->id;
                $journal->branch_id = $savings_transaction->branch_id;
                $journal->sacco_id = $savings_transaction->sacco_id;
                $journal->date = $input['date'];
                $journal->year = $input['year'];
                $journal->month = $input['month'];
                $journal->borrower_id = $savings_transaction->borrower_id;
                $journal->transaction_type = 'withdrawal';
                $journal->name = "Withdrawal";
                $journal->savings_id = $saving->id;
                $journal->debit = $amount;
                $journal->reference = $savings_transaction->id;
                $journal->save();
            }
        }
    }
}
