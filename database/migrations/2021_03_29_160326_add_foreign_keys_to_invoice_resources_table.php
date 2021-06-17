<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToInvoiceResourcesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('invoice_resources', function(Blueprint $table)
		{
			$table->foreign('currency_id')->references('id')->on('currencies')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('office_id', 'invoice_resources_ibfk_1')->references('id')->on('offices')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('country_id', 'invoice_resources_ibfk_2')->references('id')->on('countries')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('city_id', 'invoice_resources_ibfk_3')->references('id')->on('cities')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('invoice_id')->references('id')->on('invoices')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('project_role_id')->references('id')->on('project_roles')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('rate_id')->references('id')->on('rates')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('seniority_id')->references('id')->on('seniorities')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('invoice_resources', function(Blueprint $table)
		{
			$table->dropForeign('invoice_resources_currency_id_foreign');
			$table->dropForeign('invoice_resources_ibfk_1');
			$table->dropForeign('invoice_resources_ibfk_2');
			$table->dropForeign('invoice_resources_ibfk_3');
			$table->dropForeign('invoice_resources_invoice_id_foreign');
			$table->dropForeign('invoice_resources_project_role_id_foreign');
			$table->dropForeign('invoice_resources_rate_id_foreign');
			$table->dropForeign('invoice_resources_seniority_id_foreign');
			$table->dropForeign('invoice_resources_user_id_foreign');
		});
	}

}
