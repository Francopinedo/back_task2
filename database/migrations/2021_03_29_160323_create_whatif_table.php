<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWhatifTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('whatif', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('project_id')->unsigned()->index('whatifs_project_id_foreign');
			$table->text('comment', 65535);
			$table->integer('user_id')->unsigned()->index('whatifs_user_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('whatif');
	}

}
