<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCountriesTable extends Migration {

	public function up()
	{
		Schema::create('countries', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 100);
			$table->integer('language_id')->unsigned()->nullable();

			$table->integer('currency_id')->unsigned()->nullable();

		});
	}

	public function down()
	{


		Schema::drop('countries');
	}
}