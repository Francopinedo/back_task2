<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdditionalHoursTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('additional_hours', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('project_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->integer('rate_id')->unsigned()->nullable();
			$table->text('comments', 65535);
			$table->date('date');
			$table->boolean('hours');
			$table->integer('project_role_id')->unsigned()->nullable();
			$table->integer('seniority_id')->unsigned()->nullable();
			$table->float('rate', 18)->nullable();
			$table->integer('currency_id')->unsigned()->nullable();
			$table->enum('workplace', array('onsite','offshore'))->nullable();
			$table->integer('office_id')->unsigned()->nullable();
			$table->integer('country_id')->unsigned()->nullable();
			$table->integer('city_id')->unsigned()->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('additional_hours');
	}

}
