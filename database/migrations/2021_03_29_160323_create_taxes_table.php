<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaxesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('taxes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('company_id')->unsigned()->index('taxes_company_id_foreign');
			$table->string('detail', 200);
			$table->integer('country_id')->unsigned()->index('taxes_country_id_foreign');
			$table->integer('currency_id')->unsigned()->index('taxes_currency_id_foreign');
			$table->float('value', 18);
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
		Schema::drop('taxes');
	}

}
