<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToDirectoryRoleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('directory_role', function(Blueprint $table)
		{
			$table->foreign('directory_id')->references('id')->on('directories')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('role_id')->references('id')->on('roles')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('directory_role', function(Blueprint $table)
		{
			$table->dropForeign('directory_role_directory_id_foreign');
			$table->dropForeign('directory_role_role_id_foreign');
		});
	}

}
