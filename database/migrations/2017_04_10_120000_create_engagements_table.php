<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEngagementsTable extends Migration {

	public function up()
	{
		Schema::create('engagements', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 100);
		});
	}

	public function down()
	{
		Schema::drop('engagements');
	}
}