<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAbsencesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('absences', function(Blueprint $table)
		{
			$table->foreign('absence_type_id')->references('id')->on('absence_types')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('project_id')->references('id')->on('projects')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('absences', function(Blueprint $table)
		{
			$table->dropForeign('absences_absence_type_id_foreign');
			$table->dropForeign('absences_project_id_foreign');
			$table->dropForeign('absences_user_id_foreign');
		});
	}

}
