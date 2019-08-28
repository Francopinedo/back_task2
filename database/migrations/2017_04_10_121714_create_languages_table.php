<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLanguagesTable extends Migration {

	public function up()
	{
		Schema::create('languages', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 20);
			$table->string('code', 3);
		});
	}

	public function down()
	{
		Schema::drop('languages');
	}
}