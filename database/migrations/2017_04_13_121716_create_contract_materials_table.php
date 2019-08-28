<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContractMaterialsTable extends Migration {

	public function up()
	{
		Schema::create('contract_materials', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('material_id')->unsigned()->nullable();
			$table->foreign('material_id')->references('id')->on('materials')->onDelete('restrict');
			$table->string('detail', 150);
			$table->float('amount', 18,2);
			$table->float('cost', 18,2);
			$table->integer('currency_id')->unsigned();
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('restrict');
			$table->integer('contract_id')->unsigned();
            $table->foreign('contract_id')->references('id')->on('contracts')->onDelete('restrict');
			$table->boolean('reimbursable');
            $table->string('frequency', 255);
		});
	}

	public function down()
	{
        Schema::table('contract_materials', function(Blueprint $table) {
            $table->dropForeign('contract_materials_material_id_foreign');
        });

        Schema::table('contract_materials', function(Blueprint $table) {
            $table->dropForeign('contract_materials_contract_id_foreign');
        });


        Schema::table('contract_materials', function(Blueprint $table) {
            $table->dropForeign('contract_materials_currency_id_foreign');
        });


        Schema::drop('contract_materials');
	}
}