<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActivitiesHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('activities_history', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('agenda_id')->unsigned();
			$table->dateTime('date');
			$table->text('description', 65535);
			$table->integer('follower_id')->unsigned();
			$table->dateTime('due');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('activities_history');
	}

}
