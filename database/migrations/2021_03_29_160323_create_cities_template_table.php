<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCitiesTemplateTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cities_template', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 100);
			$table->string('location_name', 100);
			$table->integer('country_id')->unsigned()->index('cities_template_country_id_foreign');
			$table->string('timezone', 150)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cities_template');
	}

}
