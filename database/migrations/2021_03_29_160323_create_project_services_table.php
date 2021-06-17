<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProjectServicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('project_services', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('project_id')->unsigned()->index('project_services_project_id_foreign');
			$table->string('detail', 150);
			$table->float('cost', 18);
			$table->float('amount', 18);
			$table->integer('currency_id')->unsigned()->index('project_services_currency_id_foreign');
			$table->integer('service_id')->unsigned()->nullable()->index('project_services_service_id_foreign');
			$table->boolean('reimbursable');
			$table->enum('frequency', array('monthly','weekly'));
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('project_services');
	}

}
