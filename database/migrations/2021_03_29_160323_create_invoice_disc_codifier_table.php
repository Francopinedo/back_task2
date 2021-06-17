<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInvoiceDiscCodifierTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('invoice_disc_codifier', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('discount_id')->unsigned()->index('invoice_disc_codifier_discount_id_foreign');
			$table->integer('currency_id')->unsigned()->index('invoice_disc_codifier_currency_id_foreign');
			$table->string('name', 150);
			$table->float('percentage', 18);
			$table->boolean('overfield');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('invoice_disc_codifier');
	}

}
