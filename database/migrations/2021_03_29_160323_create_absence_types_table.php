<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAbsenceTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('absence_types', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('country_id')->unsigned()->index('absence_types_country_id_foreign');
			$table->string('title', 150);
			$table->boolean('days');
			$table->integer('city_id')->unsigned()->nullable()->index('absence_types_city_id_foreign');
			$table->integer('company_id')->unsigned()->nullable()->index('absence_types_company_id_foreign');
			$table->string('added_by', 1)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('absence_types');
	}

}
