<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToContractsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('contracts', function(Blueprint $table)
		{
			$table->foreign('currency_id')->references('id')->on('currencies')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('customer_id')->references('id')->on('customers')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('engagement_id')->references('id')->on('engagements')->onUpdate('RESTRICT')->onDelete('CASCADE');
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
		Schema::table('contracts', function(Blueprint $table)
		{
			$table->dropForeign('contracts_currency_id_foreign');
			$table->dropForeign('contracts_customer_id_foreign');
			$table->dropForeign('contracts_engagement_id_foreign');
			$table->dropForeign('contracts_project_id_foreign');
		});
	}

}
