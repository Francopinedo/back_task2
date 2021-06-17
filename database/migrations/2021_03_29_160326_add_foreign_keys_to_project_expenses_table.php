<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToProjectExpensesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('project_expenses', function(Blueprint $table)
		{
			$table->foreign('currency_id')->references('id')->on('currencies')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('expense_id')->references('id')->on('expenses')->onUpdate('RESTRICT')->onDelete('RESTRICT');
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
		Schema::table('project_expenses', function(Blueprint $table)
		{
			$table->dropForeign('project_expenses_currency_id_foreign');
			$table->dropForeign('project_expenses_expense_id_foreign');
			$table->dropForeign('project_expenses_project_id_foreign');
		});
	}

}
