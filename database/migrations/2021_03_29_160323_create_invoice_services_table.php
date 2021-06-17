<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInvoiceServicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('invoice_services', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('invoice_id')->unsigned()->index('invoice_services_invoice_id_foreign');
			$table->string('detail', 150);
			$table->float('amount', 18);
			$table->float('cost', 18);
			$table->integer('currency_id')->unsigned()->index('invoice_services_currency_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('invoice_services');
	}

}
