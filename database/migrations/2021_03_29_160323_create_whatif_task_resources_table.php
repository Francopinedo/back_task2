<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWhatifTaskResourcesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('whatif_task_resources', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('whatif_task_id')->unsigned()->index('whatif_task_resources_whatif_task_id_foreign');
			$table->integer('user_id')->unsigned()->index('whatif_task_resources_user_id_foreign');
			$table->integer('project_role_id')->unsigned()->nullable()->index('whatif_task_resources_project_role_id_foreign');
			$table->float('rate', 18)->nullable();
			$table->integer('quantity')->nullable();
			$table->integer('currency_id')->unsigned()->nullable()->index('whatif_task_resources_currency_id_foreign');
			$table->integer('seniority_id')->unsigned()->nullable()->index('whatif_task_resources_seniority_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('whatif_task_resources');
	}

}
