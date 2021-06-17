<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContractServicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contract_services', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('service_id')->unsigned()->nullable()->index('contract_services_service_id_foreign');
			$table->string('detail', 150);
			$table->float('amount', 18);
			$table->float('cost', 18);
			$table->integer('currency_id')->unsigned()->index('contract_services_currency_id_foreign');
			$table->integer('contract_id')->unsigned()->index('contract_services_contract_id_foreign');
			$table->boolean('reimbursable');
			$table->string('frequency')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contract_services');
	}

}
