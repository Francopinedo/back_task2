<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('costs', function(Blueprint $table)
		{
			$table->foreign('city_id')->references('id')->on('cities')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('company_id')->references('id')->on('companies')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('country_id')->references('id')->on('countries')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('currency_id')->references('id')->on('currencies')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('project_role_id')->references('id')->on('project_roles')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('seniority_id')->references('id')->on('seniorities')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('costs', function(Blueprint $table)
		{
			$table->dropForeign('costs_city_id_foreign');
			$table->dropForeign('costs_company_id_foreign');
			$table->dropForeign('costs_country_id_foreign');
			$table->dropForeign('costs_currency_id_foreign');
			$table->dropForeign('costs_project_role_id_foreign');
			$table->dropForeign('costs_seniority_id_foreign');
		});
	}

}
