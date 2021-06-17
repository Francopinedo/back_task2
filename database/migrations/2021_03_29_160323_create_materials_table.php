<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMaterialsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('materials', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->boolean('reimbursable');
			$table->string('detail', 100);
			$table->float('amount', 18);
			$table->float('cost', 18)->nullable();
			$table->integer('company_id')->unsigned()->index('materials_company_id_foreign');
			$table->integer('cost_currency_id')->unsigned();
			$table->integer('currency_id')->unsigned()->index('materials_currency_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('materials');
	}

}
