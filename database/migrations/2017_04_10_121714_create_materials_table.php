<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMaterialsTable extends Migration {

	public function up()
	{
		Schema::create('materials', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->tinyInteger('reimbursable');
			$table->string('detail', 100);
			$table->float('amount', 18,2);
			$table->float('cost', 18,2)->nullable();
			$table->integer('company_id')->unsigned();
			$table->integer('cost_currency_id')->unsigned();
			$table->integer('currency_id')->unsigned();

			$table->foreign('company_id')->references('id')->on('companies')
							->onDelete('restrict');

			$table->foreign('currency_id')->references('id')->on('currencies')
							->onDelete('restrict');

			// $table->foreign('cost_currency_id')->references('id')->on('currencies')
			// 				->onDelete('cascade');
		});
	}

	public function down()
	{
		Schema::drop('materials');
	}
}