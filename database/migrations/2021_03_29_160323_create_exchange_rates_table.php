<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExchangeRatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('exchange_rates', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('currency_id')->unsigned()->index('exchange_rates_currency_id_foreign');
			$table->integer('company_id')->unsigned()->index('exchange_rates_company_id_foreign');
			$table->float('value', 18);
			$table->dateTime('quotation_date')->nullable();
			$table->text('quotation_url', 65535);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('exchange_rates');
	}

}
