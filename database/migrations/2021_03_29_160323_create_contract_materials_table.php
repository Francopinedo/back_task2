<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContractMaterialsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contract_materials', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('material_id')->unsigned()->nullable()->index('contract_materials_material_id_foreign');
			$table->string('detail', 150);
			$table->float('amount', 18);
			$table->float('cost', 18);
			$table->integer('currency_id')->unsigned()->index('contract_materials_currency_id_foreign');
			$table->integer('contract_id')->unsigned()->index('contract_materials_contract_id_foreign');
			$table->boolean('reimbursable');
			$table->string('frequency');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contract_materials');
	}

}
