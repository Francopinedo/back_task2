<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExchangeRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchange_rates', function(Blueprint $table) {
        	$table->increments('id');
        	$table->timestamps();
        	$table->integer('currency_id')->unsigned();
        	$table->integer('company_id')->unsigned();
        	$table->float('value', 18, 2);

        	$table->foreign('currency_id')->references('id')->on('currencies')
						->onDelete('cascade')
						->onUpdate('cascade');

			$table->foreign('company_id')->references('id')->on('companies')
						->onDelete('cascade')
						->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exchange_rates', function(Blueprint $table) {
            $table->dropForeign('exchange_rates_currency_id_foreign');
        });

        Schema::table('exchange_rates', function(Blueprint $table) {
            $table->dropForeign('exchange_rates_company_id_foreign');
        });

        Schema::drop('exchange_rates');
    }
}
