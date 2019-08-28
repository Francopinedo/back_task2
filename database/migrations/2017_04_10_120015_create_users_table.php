<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 150)->nullable();
			$table->string('email', 100);
			$table->string('password', 100);
			$table->string('address', 150)->nullable();
			$table->string('office_phone', 20)->nullable();
			$table->string('home_phone', 20)->nullable();
			$table->string('cell_phone', 20)->nullable();
			$table->integer('city_id')->unsigned()->nullable();
			$table->integer('company_role_id')->unsigned()->nullable();
			$table->integer('project_role_id')->unsigned()->nullable();
			$table->integer('seniority_id')->unsigned()->nullable();
			$table->integer('office_id')->unsigned()->nullable();
			$table->integer('workgroup_id')->unsigned()->nullable();
			$table->string('profile_image_path', 200)->nullable();
			$table->enum('sidebar', ['sidebar_mini', 'sidebar_main_open'])->nullable();
		    $table->enum('theme', ['app_theme_a', 'app_theme_b', 'app_theme_c', 'app_theme_d', 'app_theme_e', 'app_theme_f', 'app_theme_g', 'app_theme_h', 'app_theme_i', 'app_theme_dark', 'app_theme_default'])->default('app_theme_default')->nullable();
            $table->string('remember_token', 255)->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('workplace', array('offshore','onsite'));
		});
	}

	public function down()
	{
		Schema::drop('users');
	}
}