<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAbsenceTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('absence_types', function(Blueprint $table)
		{
			$table->foreign('city_id')->references('id')->on('cities')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('company_id')->references('id')->on('companies')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('country_id')->references('id')->on('countries')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('absence_types', function(Blueprint $table)
		{
			$table->dropForeign('absence_types_city_id_foreign');
			$table->dropForeign('absence_types_company_id_foreign');
			$table->dropForeign('absence_types_country_id_foreign');
		});
	}

}
