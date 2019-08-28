<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('project_id')->unsigned();
			$table->foreign('project_id')->references('id')->on('projects')->onDelete('restrict');
			$table->integer('requirement_id')->unsigned()->nullable();
			$table->foreign('requirement_id')->references('id')->on('requirements')->onDelete('restrict');
			$table->string('description', 180);
			$table->date('start_date');
			$table->date('due_date');
			$table->tinyInteger('start_is_milestone');
			$table->tinyInteger('end_is_milestone');
			$table->tinyInteger('progress');
			$table->string('depends', 50);
			$table->string('status', 50);
			$table->tinyInteger('priority');
			$table->float('estimated_hours');
			$table->float('burned_hours');
			$table->tinyInteger('business_value');
			$table->string('phase', 180);
			$table->string('version', 180);
			$table->string('release', 180);
			$table->string('label', 180);
			$table->text('comments');
			$table->string('attachment', 180);
			$table->tinyInteger('level');
			$table->smallInteger('duration');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('tasks', function(Blueprint $table) {
            $table->dropForeign('tasks_requirement_id_foreign');
        });

        Schema::drop('tasks');
    }
}
