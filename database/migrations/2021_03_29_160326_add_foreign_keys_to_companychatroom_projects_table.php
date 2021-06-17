<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCompanychatroomProjectsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('companychatroom_projects', function(Blueprint $table)
		{
			$table->foreign('companychatroom_id')->references('id')->on('companychatroom')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('project_id')->references('id')->on('projects')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('companychatroom_projects', function(Blueprint $table)
		{
			$table->dropForeign('companychatroom_projects_companychatroom_id_foreign');
			$table->dropForeign('companychatroom_projects_project_id_foreign');
		});
	}

}
