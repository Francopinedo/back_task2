<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReplacementsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('replacements', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('absence_id')->unsigned()->index('replacements_absence_id_foreign');
			$table->integer('user_id')->unsigned()->index('replacements_user_id_foreign');
			$table->date('from');
			$table->date('to');
			$table->string('ticket', 150);
			$table->text('comment', 65535);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('replacements');
	}

}
