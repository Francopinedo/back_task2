<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCompanychatroomUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('companychatroom_users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('companychatroom_id')->unsigned()->index('companychatroom_users_companychatroom_id_foreign');
			$table->integer('user_id')->unsigned()->index('companychatroom_users_user_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('companychatroom_users');
	}

}
