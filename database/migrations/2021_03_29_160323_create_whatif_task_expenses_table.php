<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWhatifTaskExpensesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('whatif_task_expenses', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('whatif_task_id')->unsigned()->index('whatif_task_expenses_whatif_task_id_foreign');
			$table->string('detail', 180);
			$table->float('cost', 18);
			$table->float('amount', 18);
			$table->boolean('reimbursable');
			$table->integer('quantity');
			$table->integer('currency_id')->unsigned()->index('whatif_task_expenses_currency_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('whatif_task_expenses');
	}

}
