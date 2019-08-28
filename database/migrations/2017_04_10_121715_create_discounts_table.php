<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDiscountsTable extends Migration {

	public function up()
	{
		Schema::create('discounts', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('company_id')->unsigned();
			$table->string('detail', 100);
			$table->float('amount', 18,2);
			$table->float('percentage', 18,2);
			$table->integer('currency_id')->unsigned();

			$table->foreign('company_id')->references('id')->on('companies')
						->onDelete('cascade');

			$table->foreign('currency_id')->references('id')->on('currencies')
						->onDelete('cascade');

		});
	}

	public function down()
	{
		Schema::table('discounts', function(Blueprint $table) {
			$table->dropForeign('discounts_company_id_foreign');
		});

		Schema::table('discounts', function(Blueprint $table) {
			$table->dropForeign('discounts_currency_id_foreign');
		});

		Schema::drop('discounts');
	}
}