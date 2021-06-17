<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCompanychatroomWorkgroupsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('companychatroom_workgroups', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('companychatroom_id')->unsigned()->index('companychatroom_workgroups_companychatroom_id_foreign');
			$table->integer('workgroup_id')->unsigned()->index('companychatroom_workgroups_workgroup_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('companychatroom_workgroups');
	}

}
