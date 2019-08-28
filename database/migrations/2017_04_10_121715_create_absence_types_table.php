<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAbsenceTypesTable extends Migration {

	public function up()
	{
		Schema::create('absence_types', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('country_id')->unsigned();
			$table->string('title', 150);
			$table->tinyInteger('days');
		});
	}

	public function down()
	{
		Schema::drop('absence_types');
	}
}