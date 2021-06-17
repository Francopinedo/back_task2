<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToContactsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('contacts', function(Blueprint $table)
		{
			$table->foreign('city_id')->references('id')->on('cities')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('company_id')->references('id')->on('companies')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('country_id')->references('id')->on('countries')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('industry_id')->references('id')->on('industries')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('project_id')->references('id')->on('projects')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('contacts', function(Blueprint $table)
		{
			$table->dropForeign('contacts_city_id_foreign');
			$table->dropForeign('contacts_company_id_foreign');
			$table->dropForeign('contacts_country_id_foreign');
			$table->dropForeign('contacts_industry_id_foreign');
			$table->dropForeign('contacts_project_id_foreign');
		});
	}

}
