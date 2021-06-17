<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToContractServicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('contract_services', function(Blueprint $table)
		{
			$table->foreign('contract_id')->references('id')->on('contracts')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('currency_id')->references('id')->on('currencies')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('service_id')->references('id')->on('services')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('contract_services', function(Blueprint $table)
		{
			$table->dropForeign('contract_services_contract_id_foreign');
			$table->dropForeign('contract_services_currency_id_foreign');
			$table->dropForeign('contract_services_service_id_foreign');
		});
	}

}
