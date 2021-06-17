<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAgendaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('agenda', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('company_id')->unsigned();
			$table->integer('project_id')->unsigned()->nullable();
			$table->enum('knowledge_area', array('Startup-Up & Integration Management','Scope Management','Time Management','Cost Management','Quality Management','Human Resource Management','Communications Management','StakeHolder Management','Risk Management','Procurement Management'));
			$table->integer('item_number')->unsigned();
			$table->text('description', 65535);
			$table->dateTime('start');
			$table->enum('status', array('Open','Pending Internal','Pending External','In Progress','Done','Closed','Cancelled'));
			$table->dateTime('due');
			$table->integer('creator_id')->unsigned();
			$table->integer('owner_id')->unsigned();
			$table->string('detail', 200);
			$table->integer('priority')->default(1);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('agenda');
	}

}
