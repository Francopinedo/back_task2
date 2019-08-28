<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAgendaTable extends Migration {

	public function up()
	{
		Schema::create('agenda', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('company_id')->unsigned();
			$table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
			$table->integer('project_id')->unsigned()->nullable();
			$table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
			$table->enum('knowledge_area', array(
											'Startup-Up & Integration Management',
											'Scope Management',
											'Time Management',
											'Cost Management',
											'Quality Management',
											'Human Resource Management',
											'Communications Management',
											'StakeHolder Management',
											'Risk Management',
											'Procurement Management'
										));
			$table->integer('item_number')->unsigned();
			$table->text('description');
			$table->datetime('start');
			$table->enum('status', array(
											'Open',
											'Pending Internal',
											'Pending External',
											'In Progress',
											'Done',
											'Closed',
											'Cancelled'
										));
			$table->datetime('due');
			$table->integer('creator_id')->unsigned();
			$table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
			$table->integer('owner_id')->unsigned();
			$table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
			$table->string('detail', 200);
		});
	}

	public function down()
	{
		Schema::table('agenda', function(Blueprint $table) {
			$table->dropForeign('agenda_company_id_foreign');
		});

		Schema::table('agenda', function(Blueprint $table) {
			$table->dropForeign('agenda_project_id_foreign');
		});

		Schema::table('agenda', function(Blueprint $table) {
			$table->dropForeign('agenda_creator_id_foreign');
		});

		Schema::table('agenda', function(Blueprint $table) {
			$table->dropForeign('agenda_owner_id_foreign');
		});

		Schema::drop('agenda');
	}
}