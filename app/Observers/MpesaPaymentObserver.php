<?php

namespace App\Observers;

use App\Events\RepaymentCreated;
use App\Helpers\GeneralHelper;
use App\Models\Borrower;
use App\Models\CustomField;
use App\Models\CustomFieldMeta;
use App\Models\JournalEntry;
use App\Models\Loan;
use App\Models\LoanTransaction;
use App\Models\MessageTemplate;
use App\Models\MpesaPayment;
use App\Models\Saving;
use App\Models\SavingProduct;
use App\Models\SavingTransaction;
use Carbon\Carbon;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\DB;

class MpesaPaymentObserver
{
    /**
     * Handle the mpesa payment "created" event.
     *
     * @param  \App\MpesaPayment  $mpesaPayment
     * @return void
     */
    public function created(MpesaPayment $mpesaPayment)
    {
        //look for borrower with the phone number
        if($mpesaPayment->paybill == '4033091'){
            $ref = preg_replace('/\s+/', '', $mpesaPayment->bill_ref_number);
            $loanId = explode('N',$ref);
            if (count($loanId) > 1) {
                $loanId = $loanId[1];
                $loan = Loan::find($loanId);
                if(!is_null($loan)){
                    $this->processLoanPayment($loanId,$mpesaPayment);
                }
            }else{
                $borrower = Borrower::where('unique_number',$mpesaPayment->bill_ref_number)
                    ->first();
                $this->processSaving($borrower,$mpesaPayment);
            }

        }else{
            $borrower = Borrower::where('mobile',$mpesaPayment->phone_number)
                ->orWhere('phone',$mpesaPayment->phone_number)
                ->first();
            $this->processSaving($borrower,$mpesaPayment);
        }

    }


    public function updated(MpesaPayment $mpesaPayment)
    {
//        $this->sendSms($mpesaPayment);
    }

    public function processSaving($borrower,$mpesaPayment){
        DB::transaction(function () use ($borrower,$mpesaPayment){
            if(!is_null($borrower)){
                $input['date'] = Carbon::now();
                $input['time'] = Carbon::parse($input['date'])->toTimeString();
                $input['year'] = Carbon::parse($input['date'])->year;
                $input['month'] = Carbon::parse($input['date'])->month;

                $mpesaPayment->borrower_id = $borrower->id;
                $savingProduct = SavingProduct::where('name','Savings')->first();
                $savingAccount = Saving::where('borrower_id',$borrower->id)
                    ->where('savings_product_id',$savingPId = $savingProduct->id ?? 1)
                    ->first();
                if(is_null($savingAccount)){
                    $savingAccount = Saving::create([
                        'user_id' => 1,
                        'borrower_id' => $borrower->id,
                        'savings_product_id' => $savingPId,
                        'date' => $input['date'],
                        'status' => 'active',
                        'year' => $input['year'],
                        'month' => $input['month'],
                        'approved_date' => $input['date'],
                        'sacco_id' => 1,
                        'branch_id' => $borrower->branch_id
                    ]);
                }


//                    $this->_total += $saving['total'];
                $savings_transaction = new SavingTransaction();

                $savings_transaction->user_id = 1;
                $savings_transaction->borrower_id = $borrower->id;
                $savings_transaction->branch_id = $borrower->branch_id;
                $savings_transaction->receipt = $mpesaPayment->ref_number;
                $savings_transaction->amount = $mpesaPayment->amount;
                $savings_transaction->credit = $mpesaPayment->amount;
                $savings_transaction->payment_method_id = 'MPESA';
                $savings_transaction->savings_id = $savingAccount->id;
                $savings_transaction->type = 'deposit';
                $savings_transaction->sacco_id = 1;

                $savings_transaction->reversible = 1;
                $savings_transaction->date = $input['date'];
                $savings_transaction->time = $input['time'];
                $date = explode('-', $input['date']);
                $savings_transaction->year = $input['year'];
                $savings_transaction->month = $input['month'];
                $savings_transaction->notes = "";
                $savings_transaction->save();

                $amount = $mpesaPayment->amount;
                $input['type'] = "deposit";
                //make journal transactions
                if ($input['type'] == "deposit") {
                    if (!empty($savingAccount->savings_product->chart_reference)) {
                        $journal = new JournalEntry();
                        $journal->user_id = 1;
                        $journal->account_id = $savingAccount->savings_product->chart_reference->id;
                        $journal->branch_id = $savings_transaction->branch_id;
                        $journal->sacco_id = $savings_transaction->sacco_id;
                        $journal->date = $input['date'];
                        $journal->year = $input['year'];
                        $journal->month = $input['month'];
                        $journal->borrower_id = $savings_transaction->borrower_id;
                        $journal->transaction_type = 'deposit';
                        $journal->name = "Deposit";
                        $journal->savings_id = $savingAccount->id;
                        $journal->debit = $amount;
                        $journal->reference = $savings_transaction->id;
                        $journal->save();
                    }
                    if (!empty($savingAccount->savings_product->chart_control)) {
                        $journal = new JournalEntry();
                        $journal->user_id = 1;
                        $journal->account_id = $savingAccount->savings_product->chart_control->id;
                        $journal->branch_id = $savings_transaction->branch_id;
                        $journal->sacco_id = $savings_transaction->sacco_id;
                        $journal->date = $input['date'];
                        $journal->year = $input['year'];
                        $journal->month = $input['month'];
                        $journal->borrower_id = $borrower->id;
                        $journal->transaction_type = 'deposit';
                        $journal->name = "Deposit";
                        $journal->savings_id = $savingAccount->id;
                        $journal->credit = $amount;
                        $journal->reference = $savings_transaction->id;
                        $journal->save();

                    }
                }

                $mpesaPayment->status = true;
                $mpesaPayment->save();

                    $this->sendSms($mpesaPayment);

            }
        });

    }

    public function sendSms($mpesaPayment){
        $template = MessageTemplate::where('event',mpesaPaymentProcessed)->where('status',true)->first();
        if(!is_null($template)){
            if($mpesaPayment->status){
                //send mpesa processed message
                $memberSavingAccounts = Saving::where('borrower_id',$mpesaPayment->borrower_id)->get();
                $total = 0;
                if(count($memberSavingAccounts)){
                    foreach ($memberSavingAccounts as $account){
                        $amount = GeneralHelper::savings_account_balance($account->id);
                        $total = $total + $amount;
                    }
                }
                $member = Borrower::find($mpesaPayment->borrower_id);

                $mess = str_replace([
                    '@member',
                    '@date',
                    '@amount',
                    '@total',
                ], [
                    $member->first_name,
                    Carbon::parse($mpesaPayment->received_on)->format('d/m/Y'),
                    number_format($mpesaPayment->amount),
                    number_format($total)
                ], $template->message);

                GeneralHelper::send_sms3($member->phone ?? $member->mobile, $mess);
            }
        }
    }


    public function processLoanPayment($loanId,$payment){
        return DB::transaction(function()use($loanId,$payment){
            $loan = Loan::find($loanId);
            $loan_transaction = new LoanTransaction();
            $loan_transaction->user_id = 1;
            $loan_transaction->branch_id = $loan->branch_id;
            $loan_transaction->loan_id = $loan->id;
            $loan_transaction->borrower_id = $loan->borrower_id;
            $loan_transaction->transaction_type = "repayment";
            $loan_transaction->receipt = $payment->ref_number;
            $loan_transaction->date = $payment->received_on;
            $loan_transaction->reversible = 1;
            $loan_transaction->repayment_method_id = 2;
            $date = explode('-', $payment->received_on);
            $loan_transaction->year = $date[0];
            $loan_transaction->month = $date[1];
            $loan_transaction->credit = $payment->amount;
            $loan_transaction->notes = "Loan Payment via Mpesa";
            $loan_transaction->save();
            //fire payment added event
            //debit and credit the necessary accounts
            $allocation = GeneralHelper::loan_allocate_payment($loan_transaction);
            //return $allocation;
            //principal
            if ($allocation['principal'] > 0) {
                if (!empty($loan->loan_product->chart_loan_portfolio)) {
                    $journal = new JournalEntry();
                    $journal->user_id =1;
                    $journal->account_id = $loan->loan_product->chart_loan_portfolio->id;
                    $journal->branch_id = $loan->branch_id;
                    $journal->date = $payment->received_on;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->borrower_id = $loan->borrower_id;
                    $journal->transaction_type = 'repayment';
                    $journal->transaction_sub_type = 'repayment_principal';
                    $journal->name = "Principal Repayment";
                    $journal->loan_id = $loan->id;
                    $journal->loan_transaction_id = $loan_transaction->id;
                    $journal->credit = $allocation['principal'];
                    $journal->reference = $loan_transaction->id;
                    $journal->save();
                }
                if (!empty($loan->loan_product->chart_fund_source)) {
                    $journal = new JournalEntry();
                    $journal->user_id = 1;
                    $journal->account_id = $loan->loan_product->chart_fund_source->id;
                    $journal->branch_id = $loan->branch_id;
                    $journal->date = $payment->received_on;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->borrower_id = $loan->borrower_id;
                    $journal->transaction_type = 'repayment';
                    $journal->name = "Principal Repayment";
                    $journal->loan_id = $loan->id;
                    $journal->loan_transaction_id = $loan_transaction->id;
                    $journal->debit = $allocation['principal'];
                    $journal->reference = $loan_transaction->id;
                    $journal->save();
                }
            }
            //interest
            if ($allocation['interest'] > 0) {
                if (!empty($loan->loan_product->chart_income_interest)) {
                    $journal = new JournalEntry();
                    $journal->user_id = 1;
                    $journal->account_id = $loan->loan_product->chart_income_interest->id;
                    $journal->branch_id = $loan->branch_id;
                    $journal->date = $payment->received_on;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->borrower_id = $loan->borrower_id;
                    $journal->transaction_type = 'repayment';
                    $journal->transaction_sub_type = 'repayment_interest';
                    $journal->name = "Interest Repayment";
                    $journal->loan_id = $loan->id;
                    $journal->loan_transaction_id = $loan_transaction->id;
                    $journal->credit = $allocation['interest'];
                    $journal->reference = $loan_transaction->id;
                    $journal->save();
                }
                if (!empty($loan->loan_product->chart_receivable_interest)) {
                    $journal = new JournalEntry();
                    $journal->user_id = 1;
                    $journal->account_id = $loan->loan_product->chart_receivable_interest->id;
                    $journal->branch_id = $loan->branch_id;
                    $journal->date = $payment->received_on;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->borrower_id = $loan->borrower_id;
                    $journal->transaction_type = 'repayment';
                    $journal->name = "Interest Repayment";
                    $journal->loan_id = $loan->id;
                    $journal->loan_transaction_id = $loan_transaction->id;
                    $journal->debit = $allocation['interest'];
                    $journal->reference = $loan_transaction->id;
                    $journal->save();
                }
            }
            //fees
            if ($allocation['fees'] > 0) {
                if (!empty($loan->loan_product->chart_income_fee)) {
                    $journal = new JournalEntry();
                    $journal->user_id = 1;
                    $journal->account_id = $loan->loan_product->chart_income_fee->id;
                    $journal->branch_id = $loan->branch_id;
                    $journal->date = $payment->received_on;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->borrower_id = $loan->borrower_id;
                    $journal->transaction_type = 'repayment';
                    $journal->transaction_sub_type = 'repayment_fees';
                    $journal->name = "Fees Repayment";
                    $journal->loan_id = $loan->id;
                    $journal->loan_transaction_id = $loan_transaction->id;
                    $journal->credit = $allocation['fees'];
                    $journal->reference = $loan_transaction->id;
                    $journal->save();
                }
                if (!empty($loan->loan_product->chart_receivable_fee)) {
                    $journal = new JournalEntry();
                    $journal->user_id = 1;
                    $journal->account_id = $loan->loan_product->chart_receivable_fee->id;
                    $journal->branch_id = $loan->branch_id;
                    $journal->date =$payment->received_on;;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->borrower_id = $loan->borrower_id;
                    $journal->transaction_type = 'repayment';
                    $journal->name = "Fees Repayment";
                    $journal->loan_id = $loan->id;
                    $journal->loan_transaction_id = $loan_transaction->id;
                    $journal->debit = $allocation['fees'];
                    $journal->reference = $loan_transaction->id;
                    $journal->save();
                }
            }
            if ($allocation['penalty'] > 0) {
                if (!empty($loan->loan_product->chart_income_penalty)) {
                    $journal = new JournalEntry();
                    $journal->user_id = 1;
                    $journal->account_id = $loan->loan_product->chart_income_penalty->id;
                    $journal->branch_id = $loan->branch_id;
                    $journal->date = $payment->received_on;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->borrower_id = $loan->borrower_id;
                    $journal->transaction_type = 'repayment';
                    $journal->transaction_sub_type = 'repayment_penalty';
                    $journal->name = "Penalty Repayment";
                    $journal->loan_id = $loan->id;
                    $journal->loan_transaction_id = $loan_transaction->id;
                    $journal->credit = $allocation['penalty'];
                    $journal->reference = $loan_transaction->id;
                    $journal->save();
                }
                if (!empty($loan->loan_product->chart_receivable_penalty)) {
                    $journal = new JournalEntry();
                    $journal->user_id = 1;
                    $journal->account_id = $loan->loan_product->chart_receivable_penalty->id;
                    $journal->branch_id = $loan->branch_id;
                    $journal->date =$payment->received_on;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->borrower_id = $loan->borrower_id;
                    $journal->transaction_type = 'repayment';
                    $journal->name = "Penalty Repayment";
                    $journal->loan_id = $loan->id;
                    $journal->loan_transaction_id = $loan_transaction->id;
                    $journal->debit = $allocation['penalty'];
                    $journal->reference = $loan_transaction->id;
                    $journal->save();
                }
            }
            //save custom meta
            //update loan status if need be
            if (round($bal = GeneralHelper::loan_total_balance($loan->id)) <= 0) {
                $l = Loan::find($loan->id);
                $l->status = "closed";
                $l->save();
            }

            $member = Borrower::find($loan->borrower_id);
            $payment->borrower_id = $loan->borrower_id;
            $payment->status= true;
            $payment->save();
            $mess = 'Dear '.$member->first_name.' your payment of KES '.number_format($payment->amount).' has been received. New loan balance is KES '.number_format($bal).'.';
            GeneralHelper::send_sms3($member->phone ?? $member->mobile, $mess);
//            event(new RepaymentCreated($loan_transaction));
        });


    }
}
