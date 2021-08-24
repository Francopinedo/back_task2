<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTicketsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tickets', function(Blueprint $table)
		{
			$table->foreign('assignee_id')->references('id')->on('task_resources')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('last_updater_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('task_id')->references('id')->on('tasks')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('sprint_id')->references('id')->on('sprints')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tickets', function(Blueprint $table)
		{
			$table->dropForeign('tickets_assignee_id_foreign');
			$table->dropForeign('tickets_last_updater_id_foreign');
			$table->dropForeign('tickets_task_id_foreign');
			$table->dropForeign('tickets_sprint_id_foreign');
		});
	}

}
