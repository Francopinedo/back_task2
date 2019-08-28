<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReplacementsTable extends Migration {

	public function up()
	{
		Schema::create('replacements', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('absence_id')->unsigned();

			$table->integer('user_id')->unsigned();

			$table->date('from');
			$table->date('to');
			$table->string('ticket', 150);
			$table->text('comment');
		});
	}

	public function down()
	{



		Schema::drop('replacements');
	}
}