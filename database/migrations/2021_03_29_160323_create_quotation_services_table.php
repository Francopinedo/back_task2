<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuotationServicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('quotation_services', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('quotation_id')->unsigned()->index('quotation_services_quotation_id_foreign');
			$table->string('detail', 150);
			$table->float('amount', 18);
			$table->float('cost', 18);
			$table->integer('currency_id')->unsigned()->index('quotation_services_currency_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('quotation_services');
	}

}
