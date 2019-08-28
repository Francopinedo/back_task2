<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProcurementsTable extends Migration {

	public function up()
	{
		Schema::create('procurements', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('project_id')->unsigned();
			$table->foreign('project_id')->references('id')->on('projects')->onDelete('restrict');
			$table->enum('type', array('internal', 'external', 'any'));
			$table->date('date');
			$table->string('description', 180);
			$table->integer('RFPID')->nullable()->unsigned();
			$table->integer('ContractID')->nullable()->unsigned();
			$table->text('specifications');
			$table->string('approver_name', 180);
			$table->integer('responsable_id')->unsigned();

			$table->date('due_date');
			$table->float('cost', 18,2);
			$table->integer('cost_currency_id')->unsigned();
			$table->foreign('cost_currency_id')->references('id')->on('currencies')->onDelete('restrict');
			$table->tinyInteger('quality_required');
			$table->enum('contract_status', array('starting', 'running', 'standby', 'finished', 'other'));
			$table->integer('provider_id')->unsigned();

			$table->tinyInteger('provider_feedback');
			$table->string('delivery', 180);
			$table->string('quality', 180);
			$table->tinyInteger('overallscore');
			$table->enum('requirement_status', array('starting', 'running', 'waiting', 'standby','finished', 'closed'));
			$table->date('delivered_date');
		});
	}

	public function down()
	{

        Schema::table('procurements', function (Blueprint $table) {
            $table->dropForeign('procurements_provider_id_foreign');
        });

        Schema::table('procurements', function (Blueprint $table) {
            $table->dropForeign('procurements_cost_currency_id_foreign');
        });


        Schema::table('procurements', function (Blueprint $table) {
            $table->dropForeign('procurements_project_id_foreign');
        });



        Schema::drop('procurements');
	}
}