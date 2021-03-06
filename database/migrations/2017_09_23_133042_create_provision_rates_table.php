<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvisionRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provision_rates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->integer('days')->nullable();
            $table->double('rate',10,2)->default(0.00);
            $table->text('notes')->nullable();
            $table->unsignedInteger('sacco_id')->nullable();
            $table->foreign('sacco_id')->references('id')->on('saccos')->onDelete('cascade');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('provision_rates');
    }
}