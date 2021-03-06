<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayrollTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_templates',function(Blueprint $table){
            $table->increments('id');
            $table->string('name')->nullable();
            $table->text('notes')->nullable();
            $table->string('picture')->nullable();
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
        Schema::drop('payroll_templates');
    }
}
