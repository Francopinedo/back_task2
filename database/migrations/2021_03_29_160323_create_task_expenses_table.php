<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaskExpensesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('task_expenses', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('task_id')->unsigned()->index('task_expenses_task_id_foreign');
			$table->string('detail', 180);
			$table->float('cost', 18)->default(0.00);
			$table->float('amount', 18);
			$table->boolean('reimbursable');
			$table->integer('quantity');
			$table->integer('currency_id')->unsigned()->index('task_expenses_currency_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('task_expenses');
	}

}
