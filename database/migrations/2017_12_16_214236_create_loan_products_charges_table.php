<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanProductsChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_product_charges', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->integer('charge_id')->nullable();
            $table->integer('loan_product_id')->nullable();
            $table->decimal('amount', 65, 2)->nullable();
            $table->date('date')->nullable();
            $table->integer('grace_period')->default(0);
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
        Schema::drop('loan_product_charges');
    }
}
