<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDirectoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('directories', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre', 100);
			$table->string('path', 100);
			$table->boolean('borrado_logico');
			$table->integer('parent')->unsigned()->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('directories');
	}

}
