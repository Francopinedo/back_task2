CASCADE<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToProjectsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('projects', function(Blueprint $table)
		{
			$table->foreign('customer_id')->references('id')->on('customers')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('delivery_manager_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('department_id')->references('id')->on('departments')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('project_manager_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('technical_director_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('projects', function(Blueprint $table)
		{
			$table->dropForeign('projects_customer_id_foreign');
			$table->dropForeign('projects_delivery_manager_id_foreign');
			$table->dropForeign('projects_department_id_foreign');
			$table->dropForeign('projects_project_manager_id_foreign');
			$table->dropForeign('projects_technical_director_id_foreign');
		});
	}

}
