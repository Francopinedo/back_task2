<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requirements', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('project_id')->unsigned();
			$table->foreign('project_id')->references('id')->on('projects')->onDelete('restrict');
			$table->string('description', 180);
			$table->enum('type', array('project', 'product'));
			$table->date('request_date');
			$table->string('status_comment', 180);
			$table->date('due_date');
			$table->integer('owner_id')->unsigned();
			$table->foreign('owner_id')->references('id')->on('users')->onDelete('restrict');
			$table->tinyInteger('priority');
			$table->string('requester_name', 180);
			$table->string('requester_email', 180);
			$table->string('requester_type', 180);
			$table->date('approval_date');
			$table->date('approver_name');
			$table->text('comment');
            $table->tinyInteger('business_value');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requirements', function(Blueprint $table) {
            $table->dropForeign('requirements_owner_id_foreign');
        });

        Schema::table('requirements', function(Blueprint $table) {
            $table->dropForeign('requirements_project_id_foreign');
        });

        Schema::drop('requirements');
    }
}
