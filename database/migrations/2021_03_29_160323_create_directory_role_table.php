<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDirectoryRoleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('directory_role', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('directory_id')->unsigned()->index('directory_role_directory_id_foreign');
			$table->integer('role_id')->unsigned()->index('directory_role_role_id_foreign');
			$table->boolean('read');
			$table->boolean('write');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('directory_role');
	}

}
