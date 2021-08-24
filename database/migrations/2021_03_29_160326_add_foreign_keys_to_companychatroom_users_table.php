<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCompanychatroomUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('companychatroom_users', function(Blueprint $table)
		{
			$table->foreign('companychatroom_id')->references('id')->on('companychatroom')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('companychatroom_users', function(Blueprint $table)
		{
			$table->dropForeign('companychatroom_users_companychatroom_id_foreign');
			$table->dropForeign('companychatroom_users_user_id_foreign');
		});
	}

}
