<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToProjectKpiAlertsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('project_kpi_alerts', function(Blueprint $table)
		{
			$table->foreign('kpi_id')->references('id')->on('kpis')->onUpdate('RESTRICT')->onDelete('CASCADE');
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
		Schema::table('project_kpi_alerts', function(Blueprint $table)
		{
			$table->dropForeign('project_kpi_alerts_kpi_id_foreign');
			$table->dropForeign('project_kpi_alerts_project_id_foreign');
		});
	}

}
