<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuotationMaterialsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('quotation_materials', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('quotation_id')->unsigned()->index('quotation_materials_quotation_id_foreign');
			$table->integer('currency_id')->unsigned()->index('quotation_materials_currency_id_foreign');
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
		Schema::drop('quotation_materials');
	}

}
