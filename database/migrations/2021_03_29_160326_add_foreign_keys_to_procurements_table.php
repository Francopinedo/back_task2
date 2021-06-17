<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToProcurementsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('procurements', function(Blueprint $table)
		{
			$table->foreign('cost_currency_id')->references('id')->on('currencies')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('project_id')->references('id')->on('projects')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('provider_id')->references('id')->on('providers')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('responsable_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('procurements', function(Blueprint $table)
		{
			$table->dropForeign('procurements_cost_currency_id_foreign');
			$table->dropForeign('procurements_project_id_foreign');
			$table->dropForeign('procurements_provider_id_foreign');
			$table->dropForeign('procurements_responsable_id_foreign');
		});
	}

}
