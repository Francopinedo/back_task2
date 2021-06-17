<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToContractExpensesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('contract_expenses', function(Blueprint $table)
		{
			$table->foreign('contract_id')->references('id')->on('contracts')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('currency_id')->references('id')->on('currencies')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('expense_id')->references('id')->on('expenses')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('contract_expenses', function(Blueprint $table)
		{
			$table->dropForeign('contract_expenses_contract_id_foreign');
			$table->dropForeign('contract_expenses_currency_id_foreign');
			$table->dropForeign('contract_expenses_expense_id_foreign');
		});
	}

}
