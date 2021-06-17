<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToQuotationResourcesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('quotation_resources', function(Blueprint $table)
		{
			$table->foreign('city_id')->references('id')->on('cities')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('country_id')->references('id')->on('countries')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('currency_id')->references('id')->on('currencies')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('office_id')->references('id')->on('offices')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('project_role_id')->references('id')->on('project_roles')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('quotation_id')->references('id')->on('quotations')->onUpdate('RESTRICT')->onDelete('RESTRICT');
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
		Schema::table('quotation_resources', function(Blueprint $table)
		{
			$table->dropForeign('quotation_resources_city_id_foreign');
			$table->dropForeign('quotation_resources_country_id_foreign');
			$table->dropForeign('quotation_resources_currency_id_foreign');
			$table->dropForeign('quotation_resources_office_id_foreign');
			$table->dropForeign('quotation_resources_project_role_id_foreign');
			$table->dropForeign('quotation_resources_quotation_id_foreign');
			$table->dropForeign('quotation_resources_rate_id_foreign');
			$table->dropForeign('quotation_resources_seniority_id_foreign');
			$table->dropForeign('quotation_resources_user_id_foreign');
		});
	}

}
