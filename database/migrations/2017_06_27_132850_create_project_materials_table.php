<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_materials', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('project_id')->unsigned();
			$table->foreign('project_id')->references('id')->on('projects');
			$table->string('detail', 150);
			$table->float('cost', 18, 2);
			$table->float('amount', 18, 2);
			$table->integer('currency_id')->unsigned();
			$table->foreign('currency_id')->references('id')->on('currencies');
			$table->integer('material_id')->unsigned()->nullable();
			$table->foreign('material_id')->references('id')->on('materials');
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

        Schema::table('project_materials', function (Blueprint $table) {
            $table->dropForeign('project_materials_project_id_foreign');
        });


        Schema::table('project_materials', function (Blueprint $table) {
            $table->dropForeign('project_materials_currency_id_foreign');
        });


        Schema::table('project_materials', function (Blueprint $table) {
            $table->dropForeign('project_materials_material_id_foreign');
        });


        
        Schema::drop('project_materials');
    }
}
