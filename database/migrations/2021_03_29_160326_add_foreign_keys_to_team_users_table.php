<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTeamUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('team_users', function(Blueprint $table)
		{
			$table->foreign('country_id', 'team_users_ibfk_1')->references('id')->on('countries')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('city_id', 'team_users_ibfk_2')->references('id')->on('cities')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('office_id', 'team_users_ibfk_3')->references('id')->on('offices')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('project_role_id', 'team_users_ibfk_4')->references('id')->on('project_roles')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('seniority_id', 'team_users_ibfk_5')->references('id')->on('seniorities')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('project_id')->references('id')->on('projects')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('team_users', function(Blueprint $table)
		{
			$table->dropForeign('team_users_ibfk_1');
			$table->dropForeign('team_users_ibfk_2');
			$table->dropForeign('team_users_ibfk_3');
			$table->dropForeign('team_users_ibfk_4');
			$table->dropForeign('team_users_ibfk_5');
			$table->dropForeign('team_users_project_id_foreign');
			$table->dropForeign('team_users_user_id_foreign');
		});
	}

}
