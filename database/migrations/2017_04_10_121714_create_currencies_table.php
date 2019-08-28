<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCurrenciesTable extends Migration {

	public function up()
	{
		Schema::create('currencies', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('code', 3);
			$table->string('name', 40);
		});
	}

	public function down()
	{
		Schema::drop('currencies');
	}
}