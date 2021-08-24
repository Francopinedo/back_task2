<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->foreign('city_id')->references('id')->on('cities')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('company_role_id')->references('id')->on('company_roles')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('office_id')->references('id')->on('offices')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('project_role_id')->references('id')->on('project_roles')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('seniority_id')->references('id')->on('seniorities')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('workgroup_id')->references('id')->on('workgroups')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->dropForeign('users_city_id_foreign');
			$table->dropForeign('users_company_role_id_foreign');
			$table->dropForeign('users_office_id_foreign');
			$table->dropForeign('users_project_role_id_foreign');
			$table->dropForeign('users_seniority_id_foreign');
			$table->dropForeign('users_user_id_foreign');
			$table->dropForeign('users_workgroup_id_foreign');
		});
	}

}
