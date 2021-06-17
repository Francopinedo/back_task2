<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInvoiceDebitCreditTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('invoice_debit_credit', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->timestamps();
			$table->integer('invoice_id');
			$table->integer('currency_id');
			$table->text('detail', 65535);
			$table->float('cost', 18);
			$table->float('amount', 18);
			$table->enum('signs', array('+','-'));
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('invoice_debit_credit');
	}

}
