<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCurrencyUnitToRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exchange_rates', function (Blueprint $table) {
            $table->string('currency_unit', 25)->nullable()->after('currency_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exchange_rates', function (Blueprint $table) {
            $table->dropColumn('currency_unit');
        });
    }
}
