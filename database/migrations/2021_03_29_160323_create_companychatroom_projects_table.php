<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCompanychatroomProjectsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('companychatroom_projects', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('companychatroom_id')->unsigned()->index('companychatroom_projects_companychatroom_id_foreign');
			$table->integer('project_id')->unsigned()->index('companychatroom_projects_project_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('companychatroom_projects');
	}

}
