<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRocketchatUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('rocketchat_users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->string('rcuser', 191);
			$table->string('rcpass', 191);
			$table->string('rcpath', 191);
			$table->integer('user_id')->unsigned()->nullable()->index('rocketchat_users_user_id_foreign');
			$table->integer('company_id')->unsigned()->index('rocketchat_users_company_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('rocketchat_users');
	}

}
