<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRequirementsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('requirements', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('project_id')->unsigned()->index('requirements_project_id_foreign');
			$table->string('description', 180);
			$table->enum('type', array('project','product'));
			$table->date('request_date');
			$table->string('status_comment', 180);
			$table->date('due_date');
			$table->integer('owner_id')->unsigned()->index('requirements_owner_id_foreign');
			$table->boolean('priority');
			$table->string('requester_name', 180);
			$table->string('requester_email', 180);
			$table->string('requester_type', 180);
			$table->date('approval_date');
			$table->text('approver_name', 65535)->nullable();
			$table->text('comment', 65535);
			$table->boolean('business_value');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('requirements');
	}

}
