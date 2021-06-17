<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCountriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('countries', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 100);
			$table->integer('language_id')->unsigned()->nullable()->index('countries_language_id_foreign');
			$table->integer('currency_id')->unsigned()->nullable()->index('countries_currency_id_foreign');
			$table->string('code', 2)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('countries');
	}

}
