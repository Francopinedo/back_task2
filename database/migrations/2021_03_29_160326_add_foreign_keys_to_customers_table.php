<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCustomersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('customers', function(Blueprint $table)
		{
			$table->foreign('city_id')->references('id')->on('cities')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('company_id')->references('id')->on('companies')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('currency_id')->references('id')->on('currencies')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('industry_id')->references('id')->on('industries')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('customers', function(Blueprint $table)
		{
			$table->dropForeign('customers_city_id_foreign');
			$table->dropForeign('customers_company_id_foreign');
			$table->dropForeign('customers_currency_id_foreign');
			$table->dropForeign('customers_industry_id_foreign');
		});
	}

}
