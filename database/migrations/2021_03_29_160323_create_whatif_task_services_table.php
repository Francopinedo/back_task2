<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWhatifTaskServicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('whatif_task_services', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('whatif_task_id')->unsigned()->index('whatif_task_services_whatif_task_id_foreign');
			$table->string('detail', 180);
			$table->float('cost', 18)->nullable();
			$table->float('amount', 18)->nullable();
			$table->boolean('reimbursable')->nullable();
			$table->integer('quantity')->nullable();
			$table->integer('currency_id')->unsigned()->nullable()->index('whatif_task_services_currency_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('whatif_task_services');
	}

}
