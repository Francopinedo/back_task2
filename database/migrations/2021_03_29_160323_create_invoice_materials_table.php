<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInvoiceMaterialsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('invoice_materials', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('invoice_id')->unsigned()->index('invoice_materials_invoice_id_foreign');
			$table->integer('currency_id')->unsigned()->index('invoice_materials_currency_id_foreign');
			$table->string('detail', 150);
			$table->float('cost', 18);
			$table->float('amount', 18);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('invoice_materials');
	}

}
