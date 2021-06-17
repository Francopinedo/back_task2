<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToReplacementsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('replacements', function(Blueprint $table)
		{
			$table->foreign('absence_id')->references('id')->on('absences')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('replacements', function(Blueprint $table)
		{
			$table->dropForeign('replacements_absence_id_foreign');
			$table->dropForeign('replacements_user_id_foreign');
		});
	}

}
