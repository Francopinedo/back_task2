<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSenioritiesTable extends Migration {

	public function up()
	{
		Schema::create('seniorities', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('company_id')->unsigned();
			$table->string('title', 100);
		});
	}

	public function down()
	{
		Schema::drop('seniorities');
	}
}