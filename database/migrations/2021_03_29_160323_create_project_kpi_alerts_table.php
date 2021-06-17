<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProjectKpiAlertsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('project_kpi_alerts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('kpi_id')->unsigned()->default(0)->index('project_kpi_alerts_kpi_id_foreign');
			$table->integer('project_id')->unsigned()->default(0)->index('project_kpi_alerts_project_id_foreign');
			$table->float('red_alert', 18);
			$table->float('yellow_alert', 18);
			$table->float('green_alert', 18);
			$table->float('percent_green_alert', 18)->default(0.00);
			$table->float('percent_yellow_alert', 18)->default(0.00);
			$table->float('percent_red_alert', 18)->default(0.00);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('project_kpi_alerts');
	}

}
