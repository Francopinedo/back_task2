<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAbsencesTable extends Migration {

	public function up()
	{
		Schema::create('absences', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('absence_type_id')->unsigned();
			$table->integer('project_id')->unsigned();
			$table->text('comment');
			$table->date('from');
			$table->date('to');
			$table->integer('user_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('absences');
	}
}