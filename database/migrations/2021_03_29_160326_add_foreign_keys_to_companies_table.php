<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCompaniesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('companies', function(Blueprint $table)
		{
			$table->foreign('country_id')->references('id')->on('countries')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('city_id')->references('id')->on('cities')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('currency_id')->references('id')->on('currencies')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('industry_id')->references('id')->on('industries')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('companies', function(Blueprint $table)
		{
			$table->dropForeign('companies_country_id_foreign');
			$table->dropForeign('companies_city_id_foreign');
			$table->dropForeign('companies_currency_id_foreign');
			$table->dropForeign('companies_industry_id_foreign');
			$table->dropForeign('companies_user_id_foreign');
		});
	}

}
