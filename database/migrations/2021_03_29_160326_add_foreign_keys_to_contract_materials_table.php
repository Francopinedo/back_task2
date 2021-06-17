<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToContractMaterialsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('contract_materials', function(Blueprint $table)
		{
			$table->foreign('contract_id')->references('id')->on('contracts')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('currency_id')->references('id')->on('currencies')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('material_id')->references('id')->on('materials')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('contract_materials', function(Blueprint $table)
		{
			$table->dropForeign('contract_materials_contract_id_foreign');
			$table->dropForeign('contract_materials_currency_id_foreign');
			$table->dropForeign('contract_materials_material_id_foreign');
		});
	}

}
