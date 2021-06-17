<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInvoiceTaxesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('invoice_taxes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('invoice_id')->unsigned()->index('invoice_taxes_invoice_id_foreign');
			$table->integer('currency_id')->unsigned()->index('invoice_taxes_currency_id_foreign');
			$table->string('name', 150);
			$table->float('amount', 18);
			$table->float('percentage', 18);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('invoice_taxes');
	}

}
