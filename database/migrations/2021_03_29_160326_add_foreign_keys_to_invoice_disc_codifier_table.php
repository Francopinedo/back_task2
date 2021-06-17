<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToInvoiceDiscCodifierTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('invoice_disc_codifier', function(Blueprint $table)
		{
			$table->foreign('currency_id')->references('id')->on('currencies')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('discount_id')->references('id')->on('discounts')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('invoice_disc_codifier', function(Blueprint $table)
		{
			$table->dropForeign('invoice_disc_codifier_currency_id_foreign');
			$table->dropForeign('invoice_disc_codifier_discount_id_foreign');
		});
	}

}
