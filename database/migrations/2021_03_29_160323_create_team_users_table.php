<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTeamUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('team_users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('project_id')->unsigned()->index('team_users_project_id_foreign');
			$table->integer('user_id')->unsigned()->index('team_users_user_id_foreign');
			$table->integer('hours')->unsigned();
			$table->integer('load')->unsigned();
			$table->date('date_from');
			$table->date('date_to');
			$table->integer('country_id')->unsigned()->nullable()->index('country_id');
			$table->integer('city_id')->unsigned()->nullable()->index('city_id');
			$table->integer('office_id')->unsigned()->nullable()->index('office_id');
			$table->enum('workplace', array('onsite','offshore'))->nullable();
			$table->integer('project_role_id')->unsigned()->nullable()->index('project_role_id');
			$table->integer('seniority_id')->unsigned()->nullable()->index('seniority_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('team_users');
	}

}
