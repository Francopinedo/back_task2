<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCompanychatroomWorkgroupsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('companychatroom_workgroups', function(Blueprint $table)
		{
			$table->foreign('companychatroom_id')->references('id')->on('companychatroom')->onUpdate('CASCADE')->onDelete('CASCADE');
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
		Schema::table('companychatroom_workgroups', function(Blueprint $table)
		{
			$table->dropForeign('companychatroom_workgroups_companychatroom_id_foreign');
			$table->dropForeign('companychatroom_workgroups_workgroup_id_foreign');
		});
	}

}
