<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuotationsTable extends Migration {

	public function up()
	{
		Schema::create('quotations', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('project_id')->unsigned();

			$table->integer('customer_id')->unsigned();

		});
	}

	public function down()
	{

		Schema::drop('quotations');
	}
}