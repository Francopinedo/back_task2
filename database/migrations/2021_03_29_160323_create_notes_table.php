<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->string('title', 190);
			$table->text('description', 65535);
			$table->string('color', 190);
			$table->string('tag', 190);
			$table->integer('project_id')->unsigned()->nullable()->index('notes_project_id_foreign');
			$table->integer('user_id')->unsigned();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('notes');
	}

}
