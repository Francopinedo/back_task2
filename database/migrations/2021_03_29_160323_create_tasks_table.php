<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTasksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tasks', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('project_id')->unsigned()->index('tasks_project_id_foreign');
			$table->integer('requirement_id')->unsigned()->nullable()->index('tasks_requirement_id_foreign');
			$table->string('description', 180);
			$table->date('start_date');
			$table->date('due_date');
			$table->boolean('start_is_milestone');
			$table->boolean('end_is_milestone');
			$table->boolean('progress');
			$table->string('depends', 50);
			$table->string('status', 50);
			$table->boolean('priority');
			$table->float('estimated_hours', 10, 0);
			$table->float('burned_hours', 10, 0);
			$table->boolean('business_value');
			$table->string('phase', 180);
			$table->string('version', 180);
			$table->string('release', 180);
			$table->string('label', 180);
			$table->text('comments', 65535);
			$table->string('attachment', 180);
			$table->boolean('level');
			$table->smallInteger('duration');
			$table->integer('index')->nullable();
			$table->float('hours_by_day', 10, 0)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tasks');
	}

}
