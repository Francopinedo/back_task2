<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSprintsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sprints', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('customer_id')->unsigned()->index('projects_customer_id_foreign');
			$table->integer('project_id')->comment('id del proyecto');
			$table->string('short_name', 15)->comment('sprint short name ie Sprint#1');
			$table->string('long_name', 40)->comment('Long name for the Sprint');
			$table->date('start_date')->comment('Sprint start date');
			$table->date('finish_date')->comment('End dato of the sprint');
			$table->integer('Duration')->comment('Sprint Duration (in days or weeks)');
			$table->string('version', 180)->comment('version (optional)');
			$table->string('release', 180)->nullable()->comment('release name (optional)');
			$table->string('milestone', 180)->comment('mileston name (optional)');
			$table->integer('NumberOfChangesRequired');
			$table->integer('NumberOfChangesResolved');
			$table->enum('time_status', array('Not Started Yet','Started','Finished'));
			$table->enum('task_status', array('Pending','Not Completed Yet','Completed'));
			$table->integer('active')->default(1);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sprints');
	}

}
