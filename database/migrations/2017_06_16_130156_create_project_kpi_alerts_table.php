<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectKpiAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_kpi_alerts', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('kpi_id')->unsigned();
			$table->foreign('kpi_id')->references('id')->on('kpis')->onDelete('cascade');
			$table->integer('project_id')->unsigned();
			$table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
			$table->float('red_alert', 18,2);
			$table->float('yellow_alert', 18,2);
			$table->float('green_alert', 18,2);
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_kpi_alerts', function(Blueprint $table) {
			$table->dropForeign('project_kpi_alerts_kpi_id_foreign');
		});
		Schema::table('project_kpi_alerts', function(Blueprint $table) {
			$table->dropForeign('project_kpi_alerts_project_id_foreign');
		});
		Schema::drop('project_kpi_alerts');
    }
}
