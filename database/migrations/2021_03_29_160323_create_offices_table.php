<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOfficesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('offices', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->string('title', 100);
			$table->integer('company_id')->unsigned()->index('offices_company_id_foreign');
			$table->integer('city_id')->unsigned()->nullable();
			$table->string('workinghours_from', 8)->nullable();
			$table->string('workinghours_to', 8)->nullable();
			$table->integer('hours_by_day')->unsigned()->default(8);
			$table->integer('effective_workinghours')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('offices');
	}

}
