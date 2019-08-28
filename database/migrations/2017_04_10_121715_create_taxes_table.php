<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaxesTable extends Migration {

	public function up()
	{
		Schema::create('taxes', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('company_id')->unsigned();
			$table->string('detail', 200);
			$table->integer('country_id')->unsigned();
			$table->integer('currency_id')->unsigned();

			$table->float('value', 18,2);
			$table->float('percentage', 18,2);

			$table->foreign('company_id')->references('id')->on('companies')
						->onDelete('cascade');

			$table->foreign('country_id')->references('id')->on('countries')
						->onDelete('cascade');

			$table->foreign('currency_id')->references('id')->on('currencies')
						->onDelete('cascade');
		});
	}

	public function down()
	{
		Schema::table('taxes', function(Blueprint $table) {
			$table->dropForeign('taxes_company_id_foreign');
		});

		Schema::table('taxes', function(Blueprint $table) {
			$table->dropForeign('taxes_country_id_foreign');
		});

		Schema::table('taxes', function(Blueprint $table) {
			$table->dropForeign('taxes_currency_id_foreign');
		});

		Schema::drop('taxes');
	}
}