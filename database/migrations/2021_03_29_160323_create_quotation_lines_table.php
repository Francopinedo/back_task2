<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuotationLinesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('quotation_lines', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 100);
			$table->integer('quotation_id')->unsigned()->index('quotation_lines_quotation_id_foreign');
			$table->string('role', 100);
			$table->enum('workplace', array('onsite','offshore'));
			$table->string('rate', 100);
			$table->string('phase', 100);
			$table->date('start');
			$table->date('end');
			$table->boolean('load');
			$table->float('workinghours', 3);
			$table->string('comments', 250);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('quotation_lines');
	}

}
