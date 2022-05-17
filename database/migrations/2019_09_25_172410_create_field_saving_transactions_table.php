<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldSavingTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('field_saving_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('borrower_id')->unsigned()->nullable();
            $table->integer('savings_id')->unsigned()->nullable();
            $table->decimal('amount', 10, 2)->nullable()->default(0);
            $table->bigInteger('vehicle_id')->unsigned()->nullable();
            $table->enum('type', array(
                'deposit',
                'withdrawal',
                'bank_fees',
                'interest',
                'dividend',
                'guarantee',
                'guarantee_restored'
            ))->nullable();
            $table->tinyInteger('system_interest')->default(0);
            $table->date('date')->nullable();
            $table->string('time')->nullable();
            $table->string('year')->nullable();
            $table->string('month')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedInteger('sacco_id')->nullable();
            $table->foreign('sacco_id')->references('id')->on('saccos')->onDelete('cascade');
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
        Schema::dropIfExists('field_saving_transactions');
    }
}
