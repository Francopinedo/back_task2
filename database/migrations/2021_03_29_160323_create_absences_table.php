<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAbsencesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('absences', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('absence_type_id')->unsigned()->index('absences_absence_type_id_foreign');
			$table->integer('project_id')->unsigned()->index('absences_project_id_foreign');
			$table->text('comment', 65535);
			$table->date('from');
			$table->date('to');
			$table->integer('user_id')->unsigned()->index('absences_user_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('absences');
	}

}
