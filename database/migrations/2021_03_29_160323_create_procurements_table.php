<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProcurementsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('procurements', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('project_id')->unsigned()->index('procurements_project_id_foreign');
			$table->enum('type', array('internal','external','any'));
			$table->date('date');
			$table->string('description', 180);
			$table->integer('RFPID')->unsigned()->nullable();
			$table->integer('ContractID')->unsigned()->nullable();
			$table->text('specifications', 65535);
			$table->string('approver_name', 180);
			$table->integer('responsable_id')->unsigned()->index('procurements_responsable_id_foreign');
			$table->date('due_date');
			$table->float('cost', 18);
			$table->integer('cost_currency_id')->unsigned()->index('procurements_cost_currency_id_foreign');
			$table->boolean('quality_required');
			$table->enum('contract_status', array('starting','running','standby','finished','other'));
			$table->integer('provider_id')->unsigned()->index('procurements_provider_id_foreign');
			$table->boolean('provider_feedback');
			$table->string('delivery', 180);
			$table->string('quality', 180);
			$table->boolean('overallscore');
			$table->enum('requirement_status', array('starting','running','waiting','standby','finished','closed'));
			$table->date('delivered_date');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('procurements');
	}

}
