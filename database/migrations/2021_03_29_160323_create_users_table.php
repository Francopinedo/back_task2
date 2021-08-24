<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 150)->nullable();
			$table->string('email', 100);
			$table->string('password', 100);
			$table->string('address', 150)->nullable();
			$table->string('office_phone', 20)->nullable();
			$table->string('home_phone', 20)->nullable();
			$table->string('cell_phone', 20)->nullable();
			$table->integer('country_id')->nullable();
			$table->integer('city_id')->unsigned()->nullable()->index('users_city_id_foreign');
			$table->integer('company_role_id')->unsigned()->nullable()->index('users_company_role_id_foreign');
			$table->integer('project_role_id')->unsigned()->nullable()->index('users_project_role_id_foreign');
			$table->integer('seniority_id')->unsigned()->nullable()->index('users_seniority_id_foreign');
			$table->integer('office_id')->unsigned()->nullable()->index('users_office_id_foreign');
			$table->integer('workgroup_id')->unsigned()->nullable()->index('users_workgroup_id_foreign');
			$table->string('profile_image_path', 200)->nullable();
			$table->string('timezone', 100)->nullable();
			$table->enum('sidebar', array('sidebar_mini','sidebar_main_open'))->nullable();
			$table->enum('theme', array('app_theme_a','app_theme_b','app_theme_c','app_theme_d','app_theme_e','app_theme_f','app_theme_g','app_theme_h','app_theme_i','app_theme_dark','app_theme_default'))->nullable()->default('app_theme_default');
			$table->string('remember_token')->nullable();
			$table->integer('user_id')->unsigned()->nullable()->index('users_user_id_foreign');
			$table->enum('workplace', array('offshore','onsite'));
			$table->integer('tooltip')->default(1);
			$table->integer('language_id')->default(1);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
