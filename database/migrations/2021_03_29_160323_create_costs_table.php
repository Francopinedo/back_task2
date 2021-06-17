<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('costs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('company_id')->unsigned()->index('costs_company_id_foreign');
			$table->integer('country_id')->unsigned()->index('costs_country_id_foreign');
			$table->integer('city_id')->unsigned()->index('costs_city_id_foreign');
			$table->integer('seniority_id')->unsigned()->index('costs_seniority_id_foreign');
			$table->integer('project_role_id')->unsigned()->index('costs_project_role_id_foreign');
			$table->enum('workplace', array('onsite','offshore'));
			$table->string('detail', 150);
			$table->float('value', 18);
			$table->integer('currency_id')->unsigned()->index('costs_currency_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('costs');
	}

}
