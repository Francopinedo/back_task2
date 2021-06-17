<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTaskResourcesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('task_resources', function(Blueprint $table)
		{
			$table->foreign('currency_id')->references('id')->on('currencies')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('project_role_id')->references('id')->on('project_roles')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('seniority_id')->references('id')->on('seniorities')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('task_id')->references('id')->on('tasks')->onUpdate('RESTRICT')->onDelete('RESTRICT');
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
		Schema::table('task_resources', function(Blueprint $table)
		{
			$table->dropForeign('task_resources_currency_id_foreign');
			$table->dropForeign('task_resources_project_role_id_foreign');
			$table->dropForeign('task_resources_seniority_id_foreign');
			$table->dropForeign('task_resources_task_id_foreign');
			$table->dropForeign('task_resources_user_id_foreign');
		});
	}

}
