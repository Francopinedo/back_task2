<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuotationResourcesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('quotation_resources', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('quotation_id')->unsigned()->index('quotation_resources_quotation_id_foreign');
			$table->integer('project_role_id')->unsigned()->index('quotation_resources_project_role_id_foreign');
			$table->integer('seniority_id')->unsigned()->index('quotation_resources_seniority_id_foreign');
			$table->integer('currency_id')->unsigned()->index('quotation_resources_currency_id_foreign');
			$table->boolean('load');
			$table->enum('workplace', array('onsite','offshore'));
			$table->float('rate', 18);
			$table->integer('rate_id')->unsigned()->nullable()->index('quotation_resources_rate_id_foreign');
			$table->integer('hours');
			$table->string('type', 190);
			$table->integer('user_id')->unsigned()->index('quotation_resources_user_id_foreign');
			$table->text('comments', 65535)->nullable();
			$table->integer('office_id')->unsigned()->index('quotation_resources_office_id_foreign');
			$table->integer('country_id')->unsigned()->index('quotation_resources_country_id_foreign');
			$table->integer('city_id')->unsigned()->index('quotation_resources_city_id_foreign');
			$table->integer('task_id')->unsigned()->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('quotation_resources');
	}

}
