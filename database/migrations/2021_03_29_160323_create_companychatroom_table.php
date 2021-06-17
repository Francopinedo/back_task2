<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCompanychatroomTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('companychatroom', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 191);
			$table->string('fullname', 191);
			$table->string('path', 191);
			$table->string('type', 191);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('companychatroom');
	}

}
