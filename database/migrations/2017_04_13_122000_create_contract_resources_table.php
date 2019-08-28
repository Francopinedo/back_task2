<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContractResourcesTable extends Migration {

	public function up()
	{
		Schema::create('contract_resources', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('project_role_id')->unsigned();
			$table->foreign('project_role_id')->references('id')->on('project_roles')->onDelete('cascade');
			$table->integer('seniority_id')->unsigned();
			$table->foreign('seniority_id')->references('id')->on('seniorities')->onDelete('cascade');
			$table->tinyInteger('qty');
			$table->integer('rate_id')->unsigned()->nullable();
			$table->foreign('rate_id')->references('id')->on('rates')->onDelete('restrict');
			$table->float('rate', 18, 2);
			$table->integer('currency_id')->unsigned();
			$table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
			$table->tinyInteger('load');
			$table->enum('workplace', array('onsite', 'offshore'));
			$table->text('comments')->nullable();
			$table->integer('contract_id')->unsigned();
			$table->foreign('contract_id')->references('id')->on('contracts');
            $table->integer('office_id')->unsigned();
            $table->foreign('office_id')->references('id')->on('offices');

            $table->integer('country_id')->unsigned();
            $table->foreign('country_id')->references('id')->on('countries');
            $table->integer('city_id')->unsigned();
            $table->foreign('city_id')->references('id')->on('cities');
		});
	}

	public function down()
	{
		Schema::table('contract_resources', function(Blueprint $table) {
			$table->dropForeign('contract_resources_seniority_id_foreign');
		});
		Schema::table('contract_resources', function(Blueprint $table) {
			$table->dropForeign('contract_resources_rate_id_foreign');
		});
		Schema::table('contract_resources', function(Blueprint $table) {
			$table->dropForeign('contract_resources_currency_id_foreign');
		});
		Schema::table('contract_resources', function(Blueprint $table) {
			$table->dropForeign('contract_resources_contract_id_foreign');
		});
		Schema::drop('contract_resources');
	}
}