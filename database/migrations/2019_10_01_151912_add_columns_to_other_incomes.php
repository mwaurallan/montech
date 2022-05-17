<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToOtherIncomes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('other_income', function (Blueprint $table) {
            $table->unsignedInteger('borrower_id')->nullable();
            $table->foreign('borrower_id')->references('id')->on('borrowers');
            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->foreign('vehicle_id')->references('id')->on('vehicles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('other_income', function (Blueprint $table) {
            $table->dropForeign(['borrower_id']);
            $table->dropColumn(['borrower_id','vehicle_id']);

        });
    }
}
