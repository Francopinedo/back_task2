<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDebitCreditTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('debit_credit', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('company_id');
			$table->enum('code', array('proffesional hours','services','materials','others'));
			$table->enum('signs', array('+','-'));
			$table->integer('quantity')->default(1);
			$table->text('detail', 65535);
			$table->float('amount', 18);
			$table->integer('currency_id');
			$table->integer('cost_currency_id')->nullable();
			$table->enum('frequency', array('monthly','weekly','semester','anualy','bimonthly','quarterly'));
			$table->float('cost', 18);
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('debit_credit');
	}

}
