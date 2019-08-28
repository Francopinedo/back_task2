<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRatesTable extends Migration {

	public function up()
	{
		Schema::create('rates', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('company_id')->unsigned();
			$table->integer('country_id')->unsigned();
			$table->foreign('country_id')->references('id')->on('countries')->onDelete('restrict');
			$table->integer('city_id')->unsigned()->nullable();
			$table->foreign('city_id')->references('id')->on('cities')->onDelete('restrict');
			$table->integer('project_role_id')->unsigned();
			$table->foreign('project_role_id')->references('id')->on('project_roles')->onDelete('restrict');
			$table->integer('seniority_id')->unsigned();
			$table->foreign('seniority_id')->references('id')->on('seniorities')->onDelete('restrict');
			$table->string('title', 100);
			$table->float('value', 18,2);
			$table->integer('currency_id')->unsigned();
			$table->foreign('currency_id')->references('id')->on('currencies')->onDelete('restrict');
			$table->enum('workplace', array('onsite', 'offshore'));
            $table->integer('office_id')->unsigned();
            $table->foreign('office_id')->references('id')->on('offices')->onDelete('restrict');
		});
	}

	public function down()
	{
		Schema::table('rates', function(Blueprint $table) {
			$table->dropForeign('rates_country_id_foreign');
		});
		Schema::table('rates', function(Blueprint $table) {
			$table->dropForeign('rates_city_id_foreign');
		});
		Schema::table('rates', function(Blueprint $table) {
			$table->dropForeign('rates_project_role_id_foreign');
		});
		Schema::table('rates', function(Blueprint $table) {
			$table->dropForeign('rates_currency_id_foreign');
		});
        Schema::table('rates', function(Blueprint $table) {
            $table->dropForeign('rates_office_id_foreign');
        });
		Schema::drop('rates');
	}
}