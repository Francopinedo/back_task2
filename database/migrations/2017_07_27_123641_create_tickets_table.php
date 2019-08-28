<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('task_id')->unsigned();
			$table->foreign('task_id')->references('id')->on('tasks')->onDelete('restrict');
			$table->string('description', 180);
			$table->tinyInteger('type');
			$table->tinyInteger('status');
			$table->integer('assignee_id')->unsigned();
			$table->foreign('assignee_id')->references('id')->on('users')->onDelete('restrict');
			$table->tinyInteger('group');
			$table->string('sprint', 50);
			$table->integer('last_updater_id')->unsigned()->nullable();
			$table->foreign('last_updater_id')->references('id')->on('users')->onDelete('restrict');
			$table->date('due_date');
			$table->string('requester_name', 180);
			$table->string('requester_email', 100);
			$table->string('requester_type', 50);
			$table->tinyInteger('priority');
			$table->tinyInteger('severity');
			$table->tinyInteger('probability');
			$table->tinyInteger('impact');
			$table->string('version', 180);
			$table->string('release', 180);
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

			$table->integer('owner_id')->unsigned();
			$table->foreign('owner_id')->references('id')->on('users')->onDelete('restrict');
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
