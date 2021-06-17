<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateServicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('services', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->boolean('reimbursable');
			$table->string('detail', 100);
			$table->float('amount', 18);
			$table->float('cost', 18)->nullable();
			$table->integer('company_id')->unsigned()->index('services_company_id_foreign');
			$table->integer('cost_currency_id')->unsigned()->index('services_cost_currency_id_foreign');
			$table->integer('currency_id')->unsigned()->index('services_currency_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('services');
	}

}
