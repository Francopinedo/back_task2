<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuotationLinesTable extends Migration {

	public function up()
	{
		Schema::create('quotation_lines', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 100);
			$table->integer('quotation_id')->unsigned();
			$table->string('role', 100);
			$table->enum('workplace', array('onsite', 'offshore'));
			$table->string('rate', 100);
			$table->string('phase', 100);
			$table->date('start');
			$table->date('end');
			$table->tinyInteger('load');
			$table->float('workinghours', 3,2);
			$table->string('comments', 250);
		});
	}

	public function down()
	{


		Schema::drop('quotation_lines');
	}
}