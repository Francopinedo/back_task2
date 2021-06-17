<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('rates', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('company_id')->unsigned();
			$table->integer('country_id')->unsigned()->index('rates_country_id_foreign');
			$table->integer('city_id')->unsigned()->nullable()->index('rates_city_id_foreign');
			$table->integer('project_role_id')->unsigned()->index('rates_project_role_id_foreign');
			$table->integer('seniority_id')->unsigned()->index('rates_seniority_id_foreign');
			$table->string('title', 100);
			$table->float('value', 18);
			$table->integer('currency_id')->unsigned()->index('rates_currency_id_foreign');
			$table->enum('workplace', array('onsite','offshore'));
			$table->integer('office_id')->unsigned()->index('rates_office_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('rates');
	}

}
