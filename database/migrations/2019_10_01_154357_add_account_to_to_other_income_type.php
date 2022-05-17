<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAccountToToOtherIncomeType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('other_income_types', function (Blueprint $table) {
            $table->unsignedInteger('account_to')->nullable();
            $table->boolean('appear_on_receipt')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('other_income_types', function (Blueprint $table) {
            $table->dropColumn('account_to');
            $table->dropColumn('appear_on_receipt');
        });
    }
}
