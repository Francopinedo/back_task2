<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAbsenceTypesTemplateTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('absence_types_template', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('country_id')->unsigned();
			$table->integer('city_id')->unsigned();
			$table->string('title', 150);
			$table->boolean('days');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('absence_types_template');
	}

}
