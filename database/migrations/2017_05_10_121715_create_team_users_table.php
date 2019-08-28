<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTeamUsersTable extends Migration {

	public function up()
	{
		Schema::create('team_users', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('project_id')->unsigned();
            $table->foreign('project_id')->references('id')->on('projects')
                ->onDelete('cascade');
			$table->integer('user_id')->unsigned();
			$table->integer('country_id')->unsigned()->nullable();
            $table->foreign('country_id')->references('id')->on('countries')
                ->onDelete('cascade');
			$table->integer('city_id')->unsigned()->nullable();
            $table->foreign('city_id')->references('id')->on('cities')
                ->onDelete('cascade');
			$table->integer('office_id')->unsigned()->nullable();
            $table->foreign('office_id')->references('id')->on('offices')
                ->onDelete('cascade');

			$table->enum('workplace', array('onsite', 'offshore'));

			$table->integer('project_role_id')->unsigned()->nullable();
            $table->foreign('project_role_id')->references('id')->on('project_roles')
                ->onDelete('cascade');
			$table->integer('seniority_id')->unsigned()->nullable();
            $table->foreign('seniority_id')->references('id')->on('seniorities')
                ->onDelete('cascade');

            $table->integer('hours')->unsigned();
            $table->integer('load')->unsigned();
            $table->date('date_from');
            $table->date('date_to');
		});
	}

	public function down()
	{
        Schema::table('team_users', function(Blueprint $table) {
            $table->dropForeign('team_users_project_id_foreign');
        });




        Schema::drop('team_users');
	}
}