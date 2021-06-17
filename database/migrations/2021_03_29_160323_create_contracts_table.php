<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContractsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contracts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('customer_id')->unsigned()->index('contracts_customer_id_foreign');
			$table->integer('project_id')->unsigned()->nullable()->index('contracts_project_id_foreign');
			$table->string('sow_number', 150);
			$table->string('amendment_number', 150)->nullable();
			$table->date('date');
			$table->date('start_date');
			$table->date('finish_date');
			$table->integer('engagement_id')->unsigned()->index('contracts_engagement_id_foreign');
			$table->text('service_description', 65535);
			$table->string('workinghours_from', 191)->nullable();
			$table->string('workinghours_to', 191)->nullable();
			$table->integer('currency_id')->unsigned()->index('contracts_currency_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contracts');
	}

}
