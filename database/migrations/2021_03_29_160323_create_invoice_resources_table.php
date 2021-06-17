<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInvoiceResourcesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('invoice_resources', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('invoice_id')->unsigned()->index('invoice_resources_invoice_id_foreign');
			$table->integer('project_role_id')->unsigned()->index('invoice_resources_project_role_id_foreign');
			$table->integer('seniority_id')->unsigned()->index('invoice_resources_seniority_id_foreign');
			$table->integer('currency_id')->unsigned()->index('invoice_resources_currency_id_foreign');
			$table->boolean('load');
			$table->enum('workplace', array('onsite','offshore'));
			$table->float('rate', 18);
			$table->integer('rate_id')->unsigned()->nullable()->index('invoice_resources_rate_id_foreign');
			$table->integer('hours');
			$table->string('type', 190);
			$table->integer('user_id')->unsigned()->index('invoice_resources_user_id_foreign');
			$table->text('comments', 65535)->nullable();
			$table->integer('office_id')->unsigned()->nullable()->index('office_id');
			$table->integer('country_id')->unsigned()->nullable()->index('country_id');
			$table->integer('city_id')->unsigned()->nullable()->index('city_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('invoice_resources');
	}

}
