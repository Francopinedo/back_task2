<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToInvoicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('invoices', function(Blueprint $table)
		{
			$table->foreign('contact_id')->references('id')->on('contacts')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('currency_id')->references('id')->on('currencies')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('project_id')->references('id')->on('projects')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('invoices', function(Blueprint $table)
		{
			$table->dropForeign('invoices_contact_id_foreign');
			$table->dropForeign('invoices_currency_id_foreign');
			$table->dropForeign('invoices_project_id_foreign');
		});
	}

}
