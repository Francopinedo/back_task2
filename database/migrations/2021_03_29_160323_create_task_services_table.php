<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaskServicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('task_services', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('task_id')->unsigned()->index('task_services_task_id_foreign');
			$table->string('detail', 180);
			$table->float('cost', 18)->nullable();
			$table->float('amount', 18)->nullable();
			$table->boolean('reimbursable')->nullable();
			$table->integer('quantity')->nullable();
			$table->integer('currency_id')->unsigned()->nullable()->index('task_services_currency_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('task_services');
	}

}
