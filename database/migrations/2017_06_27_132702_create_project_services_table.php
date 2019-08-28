<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_services', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('project_id')->unsigned();
			$table->foreign('project_id')->references('id')->on('projects');
			$table->string('detail', 150);
			$table->float('cost', 18, 2);
			$table->float('amount', 18, 2);
			$table->integer('currency_id')->unsigned();
			$table->foreign('currency_id')->references('id')->on('currencies');
			$table->integer('service_id')->unsigned()->nullable();
			$table->foreign('service_id')->references('id')->on('services');
			$table->boolean('reimbursable');
            $table->enum('frequency', array('monthly','weekly'));
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_services', function (Blueprint $table) {
            $table->dropForeign('project_services_project_id_foreign');
        });


        Schema::table('project_services', function (Blueprint $table) {
            $table->dropForeign('project_services_currency_id_foreign');
        });


        Schema::table('project_services', function (Blueprint $table) {
            $table->dropForeign('project_services_material_id_foreign');
        });
        
        Schema::drop('project_services');
    }
}
