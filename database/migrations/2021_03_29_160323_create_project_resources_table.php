<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProjectResourcesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('project_resources', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('project_id')->unsigned()->index('project_resources_project_id_foreign');
			$table->integer('user_id')->unsigned()->nullable()->index('project_resources_user_id_foreign');
			$table->integer('project_role_id')->unsigned()->index('project_resources_project_role_id_foreign');
			$table->integer('seniority_id')->unsigned()->index('project_resources_seniority_id_foreign');
			$table->integer('rate_id')->unsigned()->nullable()->index('project_resources_rate_id_foreign');
			$table->float('rate', 18);
			$table->integer('currency_id')->unsigned()->index('project_resources_currency_id_foreign');
			$table->boolean('load');
			$table->enum('workplace', array('onsite','offshore'));
			$table->text('comments', 65535)->nullable();
			$table->integer('office_id')->unsigned()->nullable()->index('office_id');
			$table->integer('country_id')->unsigned()->nullable()->index('country_id');
			$table->integer('city_id')->unsigned()->nullable()->index('city_id');
			$table->enum('type', array('ordinary','additional'))->nullable()->default('ordinary');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('project_resources');
	}

}
