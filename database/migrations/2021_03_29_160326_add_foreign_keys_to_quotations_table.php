<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToQuotationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('quotations', function(Blueprint $table)
		{
			$table->foreign('contact_id')->references('id')->on('contacts')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('currency_id')->references('id')->on('currencies')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('customer_id')->references('id')->on('customers')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('project_id')->references('id')->on('projects')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('quotations', function(Blueprint $table)
		{
			$table->dropForeign('quotations_contact_id_foreign');
			$table->dropForeign('quotations_currency_id_foreign');
			$table->dropForeign('quotations_customer_id_foreign');
			$table->dropForeign('quotations_project_id_foreign');
		});
	}

}
