<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCitiesTable extends Migration {

	public function up()
	{
		Schema::create('cities', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 100);
			$table->string('location_name', 100);
			$table->integer('country_id')->unsigned();
			$table->string('timezone', 150)->nullable();
		});
	}

	public function down()
	{
		Schema::drop('cities');
	}
}