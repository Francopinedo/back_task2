<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCostsTable extends Migration {

	public function up()
	{
		Schema::create('costs', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('company_id')->unsigned();

			$table->integer('country_id')->unsigned();

			$table->integer('city_id')->unsigned();

			$table->integer('seniority_id')->unsigned();

			$table->integer('project_role_id')->unsigned();

			$table->enum('workplace', array('onsite', 'offshore'));
			$table->string('detail', 150);
			$table->float('value', 18,2);
			$table->integer('currency_id')->unsigned();

		});
	}

	public function down()
	{


		Schema::drop('costs');
	}
}