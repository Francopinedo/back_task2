<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCountriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('countries', function(Blueprint $table)
		{
			$table->foreign('currency_id')->references('id')->on('currencies')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('language_id')->references('id')->on('languages')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('countries', function(Blueprint $table)
		{
			$table->dropForeign('countries_currency_id_foreign');
			$table->dropForeign('countries_language_id_foreign');
		});
	}

}
