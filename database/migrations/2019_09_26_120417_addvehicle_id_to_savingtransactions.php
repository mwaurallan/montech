<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddvehicleIdToSavingtransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('savings_transactions', function (Blueprint $table) {
            $table->bigInteger('vehicle_id')->unsigned()->nullable()->index();
        });
        Schema::table('journal_entries', function (Blueprint $table) {
            $table->bigInteger('vehicle_id')->unsigned()->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('savings_transactions', function (Blueprint $table) {
            $table->dropColumn('vehicle_id');
        });
        Schema::table('journal_entries', function (Blueprint $table) {
            $table->dropColumn('vehicle_id');
        });
    }
}
