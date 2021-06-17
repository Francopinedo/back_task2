<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHolidaysTemplatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('holidays_templates', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->date('date');
			$table->string('description', 100);
			$table->integer('country_id')->unsigned()->index('holidays_templates_country_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('holidays_templates');
	}

}
