<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToProjectMaterialsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('project_materials', function(Blueprint $table)
		{
			$table->foreign('currency_id')->references('id')->on('currencies')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('material_id')->references('id')->on('materials')->onUpdate('RESTRICT')->onDelete('RESTRICT');
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
		Schema::table('project_materials', function(Blueprint $table)
		{
			$table->dropForeign('project_materials_currency_id_foreign');
			$table->dropForeign('project_materials_material_id_foreign');
			$table->dropForeign('project_materials_project_id_foreign');
		});
	}

}
