<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHolidaysTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('holidays', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->date('date');
			$table->string('description', 100);
			$table->integer('country_id')->unsigned()->index('holidays_country_id_foreign');
			$table->integer('company_id')->unsigned()->index('holidays_company_id_foreign');
			$table->string('added_by', 10);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('holidays');
	}

}
