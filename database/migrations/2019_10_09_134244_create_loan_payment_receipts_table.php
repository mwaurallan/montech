<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanPaymentReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_payment_receipts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('borrower_id')->unsigned();
            $table->date('date');
            $table->integer('vehicle_id')->nullable();
            $table->string('receipt')->nullable();
            $table->double('amount');
            $table->integer('user_id')->nullable();
            $table->boolean('status')->default(false);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loan_payment_receipts');
    }
}
