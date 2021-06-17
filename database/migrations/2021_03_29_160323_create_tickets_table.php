<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTicketsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tickets', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('task_id')->unsigned()->index('tickets_task_id_foreign');
			$table->string('description', 180);
			$table->boolean('type');
			$table->boolean('status');
			$table->integer('assignee_id')->unsigned()->index('tickets_assignee_id_foreign');
			$table->boolean('group');
			$table->string('sprint', 50);
			$table->integer('last_updater_id')->unsigned()->nullable()->index('tickets_last_updater_id_foreign');
			$table->date('due_date');
			$table->string('requester_name', 180);
			$table->string('requester_email', 100);
			$table->string('requester_type', 50);
			$table->boolean('priority');
			$table->boolean('severity');
			$table->boolean('probability');
			$table->boolean('impact');
			$table->string('version', 180);
			$table->string('release', 180);
			$table->string('milestone', 180);
			$table->smallInteger('estimated_hours');
			$table->smallInteger('burned_hours');
			$table->smallInteger('story_points');
			$table->date('approval_date');
			$table->string('approver_name', 150);
			$table->string('acceptance_criteria', 180);
			$table->string('testing_criteria', 180);
			$table->string('done_criteria', 180);
			$table->string('label', 180);
			$table->string('comment', 180);
			$table->integer('owner_id')->unsigned()->index('tickets_owner_id_foreign');
			$table->text('contingency_plan', 65535)->nullable();
			$table->integer('sprint_id')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tickets');
	}

}
