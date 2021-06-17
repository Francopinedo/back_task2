<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToServicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('services', function(Blueprint $table)
		{
			$table->foreign('company_id')->references('id')->on('companies')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('cost_currency_id')->references('id')->on('currencies')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('currency_id')->references('id')->on('currencies')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('services', function(Blueprint $table)
		{
			$table->dropForeign('services_company_id_foreign');
			$table->dropForeign('services_cost_currency_id_foreign');
			$table->dropForeign('services_currency_id_foreign');
		});
	}

}
