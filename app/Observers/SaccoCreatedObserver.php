<?php

namespace App\Observers;

use App\Models\Branch;
use App\Models\BranchUser;
use App\Models\ChartOfAccount;
use App\Models\Role;
use App\Models\Sacco;
use App\Models\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\DB;

class SaccoCreatedObserver
{

    /**
     * Handle the sacco "created" event.
     *
     * @param  \App\Sacco  $sacco
     * @return void
     */
    public function created(Sacco $sacco)
    {
        if(Sentinel::check()){
            DB::transaction(function ()use($sacco){
                //seed roles for this user
                $role = Role::create([
                    'slug' => coAdmin,
                    'name' => 'Co Admin',
                    'sacco_id' => $sacco->id,
                    'permissions' => '{"borrowers":true,"borrowers.view":true,"borrowers.update":true,"borrowers.delete":true,"borrowers.create":true,"borrowers.approve":true,"borrowers.blacklist":true,"borrowers.groups":true,"loans":true,"loans.create":true,"loans.update":true,"loans.delete":true,"loans.view":true,"loans.products":true,"loans.fees":true,"loans.schedule":true,"loans.approve":true,"loans.disburse":true,"loans.withdraw":true,"loans.writeoff":true,"loans.reschedule":true,"loans.guarantor.create":true,"loans.guarantor.update":true,"loans.guarantor.delete":true,"loans.guarantor.savings":true,"loans.loan_calculator":true,"repayments":true,"repayments.view":true,"repayments.create":true,"repayments.delete":true,"repayments.update":true,"payroll":true,"payroll.view":true,"payroll.update":true,"payroll.delete":true,"payroll.create":true,"expenses":true,"expenses.view":true,"expenses.create":true,"expenses.update":true,"expenses.delete":true,"other_income":true,"other_income.view":true,"other_income.create":true,"other_income.update":true,"other_income.delete":true,"collateral":true,"collateral.view":true,"collateral.update":true,"collateral.create":true,"collateral.delete":true,"reports":true,"communication":true,"communication.create":true,"communication.delete":true,"custom_fields":true,"custom_fields.view":true,"custom_fields.create":true,"custom_fields.update":true,"custom_fields.delete":true,"users":true,"users.view":true,"users.create":true,"users.update":true,"users.delete":true,"users.roles":true,"settings":true,"audit_trail":true,"savings":true,"savings.create":true,"savings.update":true,"savings.delete":true,"savings.transactions.create":true,"savings.transactions.update":true,"savings.transactions.delete":true,"savings.view":true,"savings.transactions.view":true,"savings.products":true,"savings.fees":true,"dashboard":true,"dashboard.loans_released_monthly_graph":true,"dashboard.loans_collected_monthly_graph":true,"dashboard.registered_borrowers":true,"dashboard.total_loans_released":true,"dashboard.total_collections":true,"dashboard.loans_disbursed":true,"dashboard.loans_pending":true,"dashboard.loans_approved":true,"dashboard.loans_declined":true,"dashboard.loans_closed":true,"dashboard.loans_withdrawn":true,"dashboard.loans_written_off":true,"dashboard.loans_rescheduled":true,"capital":true,"capital.view":true,"capital.create":true,"capital.update":true,"capital.delete":true,"assets":true,"assets.create":true,"assets.view":true,"assets.update":true,"assets.delete":true,"branches":true,"branches.view":true,"branches.create":true,"branches.update":true,"branches.delete":true,"branches.assign":true,"stock":true,"stock.view":true,"stock.create":true,"stock.update":true,"stock.delete":true}'
                ]);

                //create user
                $credentials = array(
                    "email" => $sacco->admin_email,
                    "password" => '123456',
                    "first_name" => $sacco->admin_first_name,
                    "last_name" => $sacco->admin_last_name,
                    'sacco_id' => $sacco->id,
                    'address' => $sacco->admin_address,
                    'gender' => $sacco->gender,
                    'phone' => $sacco->admin_phone
                );

                $user = \Cartalyst\Sentinel\Laravel\Facades\Sentinel::registerAndActivate($credentials);
                $u = User::where('id',$user->id)->withoutGlobalScopes()->first();
                $u->sacco_id = $sacco->id;
                $u->save();
                $role->users()->attach($user);

                //create branch
                $branch = Branch::withoutGlobalScopes()->create([
                    'name' => $sacco->name,
                    'sacco_id' => $sacco->id,
                    'default_branch' => true
                ]);

                //attach user to branch
                BranchUser::create([
                    'branch_id' => $branch->id,
                    'user_id' => $user->id,
                    'sacco_id' => $sacco->id,
                ]);

                //seed settings
                \Illuminate\Support\Facades\DB::table('settings')->insert([
                    [
                        'setting_key' => 'company_name',
                        'setting_value' => $sacco->name,
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'company_address',
                        'setting_value' => $sacco->address,
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'company_currency',
                        'setting_value' => 'KSH',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'company_website',
                        'setting_value' => 'https://www.salasa.co.ke',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'company_country',
                        'setting_value' => '113',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'system_version',
                        'setting_value' => '1.0',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'sms_enabled',
                        'setting_value' => '1',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'active_sms',
                        'setting_value' => 'infobip',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'portal_address',
                        'setting_value' => 'http://www.salasa.co.ke/client',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'company_email',
                        'setting_value' => 'info@openpathsolutions.co.ke',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'currency_symbol',
                        'setting_value' => 'KSH',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'currency_position',
                        'setting_value' => 'left',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'company_logo',
                        'setting_value' => 'logo.jpg',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'twilio_sid',
                        'setting_value' => '',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'twilio_token',
                        'setting_value' => '',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'twilio_phone_number',
                        'setting_value' => '',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'routesms_host',
                        'setting_value' => '',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'routesms_username',
                        'setting_value' => '',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'routesms_password',
                        'setting_value' => '',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'routesms_port',
                        'setting_value' => '',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'sms_sender',
                        'setting_value' => '',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'clickatell_username',
                        'setting_value' => '',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'clickatell_password',
                        'setting_value' => '',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'clickatell_api_id',
                        'setting_value' => '',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'paypal_email',
                        'setting_value' => '',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'currency',
                        'setting_value' => 'KES',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'password_reset_subject',
                        'setting_value' => 'Password reset instructions',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'password_reset_template',
                        'setting_value' => 'Password reset instructions',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'payment_received_sms_template',
                        'setting_value' => 'Dear {borrowerFirstName}, we have received your payment of ${paymentAmount} for loan {loanNumber}. New loan balance:${loanBalance}. Thank you',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'payment_received_email_template',
                        'setting_value' => 'Dear {borrowerFirstName}, we have received your payment of ${paymentAmount} for loan {loanNumber}. New loan balance:${loanBalance}. Thank you',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'payment_received_email_subject',
                        'setting_value' => 'Payment Received',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'payment_email_subject',
                        'setting_value' => 'Payment Receipt',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'payment_email_template',
                        'setting_value' => 'Dear {borrowerFirstName}, find attached receipt of your payment of ${paymentAmount} for loan {loanNumber} on {paymentDate}. New loan balance:${loanBalance}. Thank you',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'borrower_statement_email_subject',
                        'setting_value' => 'Client Statement',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'borrower_statement_email_template',
                        'setting_value' => 'Dear {borrowerFirstName}, find attached statement of your loans with us. Thank you',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'loan_statement_email_subject',
                        'setting_value' => 'Loan Statement',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'loan_statement_email_template',
                        'setting_value' => 'Dear {borrowerFirstName}, find attached loan statement for loan {loanNumber}. Thank you',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'loan_schedule_email_subject',
                        'setting_value' => 'Loan Schedule',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'loan_schedule_email_template',
                        'setting_value' => 'Dear {borrowerFirstName}, find attached loan schedule for loan {loanNumber}. Thank you',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'cron_last_run',
                        'setting_value' => '',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'auto_apply_penalty',
                        'setting_value' => '0',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'auto_payment_receipt_sms',
                        'setting_value' => '0',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'auto_payment_receipt_email',
                        'setting_value' => '1',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'auto_repayment_sms_reminder',
                        'setting_value' => '0',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'auto_repayment_email_reminder',
                        'setting_value' => '1',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'auto_repayment_days',
                        'setting_value' => '4',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'auto_overdue_repayment_sms_reminder',
                        'setting_value' => '0',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'auto_overdue_repayment_email_reminder',
                        'setting_value' => '1',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'auto_overdue_repayment_days',
                        'setting_value' => '2',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'auto_overdue_loan_sms_reminder',
                        'setting_value' => '0',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'auto_overdue_loan_email_reminder',
                        'setting_value' => '1',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'auto_overdue_loan_days',
                        'setting_value' => '2',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'loan_overdue_email_subject',
                        'setting_value' => 'Loan Overdue',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'loan_overdue_email_template',
                        'setting_value' => 'Dear {borrowerFirstName}, Your loan {loanNumber} is overdue. Please make your payment. Thank you',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'loan_overdue_sms_template',
                        'setting_value' => 'Dear {borrowerFirstName}, Your loan {loanNumber} is overdue. Please make your payment. Thank you',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'loan_payment_reminder_subject',
                        'setting_value' => 'Upcoming Payment Reminder',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'loan_payment_reminder_email_template',
                        'setting_value' => 'Dear {borrowerFirstName},You have an upcoming payment of {paymentAmount} due on {paymentDate} for loan {loanNumber}. Please make your payment. Thank you',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'loan_payment_reminder_sms_template',
                        'setting_value' => 'Dear {borrowerFirstName},You have an upcoming payment of {paymentAmount} due on {paymentDate} for loan {loanNumber}. Please make your payment. Thank you',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'missed_payment_email_subject',
                        'setting_value' => 'Missed Payment',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'missed_payment_email_template',
                        'setting_value' => 'Dear {borrowerFirstName},You missed  payment of {paymentAmount} which was due on {paymentDate} for loan {loanNumber}. Please make your payment. Thank you',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'missed_payment_sms_template',
                        'setting_value' => 'Dear {borrowerFirstName},You missed  payment of {paymentAmount} which was due on {paymentDate} for loan {loanNumber}. Please make your payment. Thank you',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'enable_cron',
                        'setting_value' => '0',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'infobip_username',
                        'setting_value' => '',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'infobip_password',
                        'setting_value' => '',
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'allow_self_registration',
                        'setting_value' => 0,
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'client_auto_activate_account',
                        'setting_value' => 0,
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'allow_client_apply',
                        'setting_value' => 1,
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'allow_client_login',
                        'setting_value' => 1,
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'auto_post_savings_interest',
                        'setting_value' => 0,
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'setting_key' => 'allow_bank_overdraw',
                        'setting_value' => 0,
                        'sacco_id' => $sacco->id
                    ],

                ]);

                //create chart of accounts
                $accs = [
                    [
                        'gl_code' => 100,
                        'name' => 'Income',
                        'account_type' => 'income',
                        'notes' => 'Income Accounts',
                        'active' => true,
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'gl_code' => 200,
                        'name' => 'Expenses',
                        'account_type' => 'expense',
                        'notes' => 'Expense Accounts',
                        'active' => true,
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'gl_code' => 300,
                        'name' => 'Assets',
                        'account_type' => 'asset',
                        'notes' => 'Asset Accounts',
                        'active' => true,
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'gl_code' => 400,
                        'name' => 'Liabilities',
                        'account_type' => 'liability',
                        'notes' => 'Liability Accounts',
                        'active' => true,
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'gl_code' => 500,
                        'name' => 'Equity',
                        'account_type' => 'equity',
                        'notes' => 'Equity Accounts',
                        'active' => true,
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'gl_code' => 110,
                        'name' => 'ApplicationFee',
                        'account_type' => 'income',
                        'notes' => '',
                        'active' => true,
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'gl_code' => 120,
                        'name' => 'RegistrationFee',
                        'account_type' => 'income',
                        'notes' => '',
                        'active' => true,
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'gl_code' => 130,
                        'name' => 'Penalties',
                        'account_type' => 'income',
                        'notes' => '',
                        'active' => true,
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'gl_code' => 140,
                        'name' => 'Recovery',
                        'account_type' => 'income',
                        'notes' => '',
                        'active' => true,
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'gl_code' => 150,
                        'name' => 'Interest',
                        'account_type' => 'income',
                        'notes' => '',
                        'active' => true,
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'gl_code' => 210,
                        'name' => 'Loans_Written_off',
                        'account_type' => 'expense',
                        'notes' => '',
                        'active' => true,
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'gl_code' => 310,
                        'name' => 'LoanFund',
                        'account_type' => 'asset',
                        'notes' => '',
                        'active' => true,
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'gl_code' => 320,
                        'name' => 'Loans',
                        'account_type' => 'asset',
                        'notes' => 'Client Loans',
                        'active' => true,
                        'sacco_id' => $sacco->id
                    ],
                    [
                        'gl_code' => 410,
                        'name' => 'Overpayments',
                        'account_type' => 'liability',
                        'notes' => '',
                        'active' => true,
                        'sacco_id' => $sacco->id
                    ],
                ];


                foreach ($accs as $acc){
                    $accounts = ChartOfAccount::create([
                        'name'=> $acc['name'],
                        'gl_code' => $acc['gl_code'],
                        'account_type' => $acc['account_type'],
                        'active' => $acc['active'],
                        'notes' => $acc['notes'],
                        'sacco_id' => $acc['sacco_id']
                ]);
                }


            });
        }

    }

    /**
     * Handle the sacco "updated" event.
     *
     * @param  \App\Sacco  $sacco
     * @return void
     */
    public function updated(Sacco $sacco)
    {
        //
    }

    /**
     * Handle the sacco "deleted" event.
     *
     * @param  \App\Sacco  $sacco
     * @return void
     */
    public function deleted(Sacco $sacco)
    {
        //
    }

    /**
     * Handle the sacco "restored" event.
     *
     * @param  \App\Sacco  $sacco
     * @return void
     */
    public function restored(Sacco $sacco)
    {
        //
    }

    /**
     * Handle the sacco "force deleted" event.
     *
     * @param  \App\Sacco  $sacco
     * @return void
     */
    public function forceDeleted(Sacco $sacco)
    {
        //
    }
}
