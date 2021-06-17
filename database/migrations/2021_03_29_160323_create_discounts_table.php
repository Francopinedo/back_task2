<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDiscountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('discounts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('company_id')->unsigned()->index('discounts_company_id_foreign');
			$table->string('detail', 100);
			$table->float('amount', 18);
			$table->float('percentage', 18);
			$table->integer('currency_id')->unsigned()->index('discounts_currency_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('discounts');
	}

}
