<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToWhatifTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('whatif', function(Blueprint $table)
		{
			$table->foreign('project_id', 'whatifs_project_id_foreign')->references('id')->on('projects')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('user_id', 'whatifs_user_id_foreign')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('whatif', function(Blueprint $table)
		{
			$table->dropForeign('whatifs_project_id_foreign');
			$table->dropForeign('whatifs_user_id_foreign');
		});
	}

}
