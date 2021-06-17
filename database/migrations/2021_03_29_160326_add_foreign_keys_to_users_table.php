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
			$table->foreign('city_id')->references('id')->on('cities')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('company_role_id')->references('id')->on('company_roles')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('office_id')->references('id')->on('offices')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('project_role_id')->references('id')->on('project_roles')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('seniority_id')->references('id')->on('seniorities')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('workgroup_id')->references('id')->on('workgroups')->onUpdate('RESTRICT')->onDelete('RESTRICT');
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
