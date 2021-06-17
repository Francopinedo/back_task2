<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuotationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('quotations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('project_id')->unsigned()->index('quotations_project_id_foreign');
			$table->integer('customer_id')->unsigned()->index('quotations_customer_id_foreign');
			$table->string('number', 200);
			$table->string('concept', 200);
			$table->date('from');
			$table->date('to');
			$table->integer('contact_id')->unsigned()->index('quotations_contact_id_foreign');
			$table->integer('currency_id')->unsigned()->index('quotations_currency_id_foreign');
			$table->date('due_date')->nullable();
			$table->float('total');
			$table->string('bill_to', 200);
			$table->string('remit_to', 200);
			$table->boolean('emited');
			$table->text('comments', 65535);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('quotations');
	}

}
