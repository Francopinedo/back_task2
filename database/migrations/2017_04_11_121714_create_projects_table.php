<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProjectsTable extends Migration {

	public function up()
	{
		Schema::create('projects', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 200);
			$table->integer('customer_id')->unsigned();
			$table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
			$table->string('customer_name', 150);
			$table->date('start');
			$table->date('finish');
			$table->integer('project_manager_id')->unsigned();
			$table->foreign('project_manager_id')->references('id')->on('users')->onDelete('cascade');
			$table->integer('technical_director_id')->unsigned();
			$table->foreign('technical_director_id')->references('id')->on('users')->onDelete('cascade');
			$table->integer('delivery_manager_id')->unsigned();
			$table->foreign('delivery_manager_id')->references('id')->on('users')->onDelete('cascade');
			$table->string('sow_number', 150);
			$table->string('identificator', 100)->nullable();
			$table->enum('status', array('initiating', 'planning', 'executing', 'closing', 'waiting'));
			$table->string('presales_responsable', 150);
			$table->string('technical_estimator', 150);
			$table->enum('engagement', array(' Staff Augmentation', 'Time & Materiales'));
			$table->float('estimated_revenue', 18,2);
			$table->float('estimated_cost', 18,2);
			$table->float('estimated_margin', 18,2);
			$table->float('estimated_department_margin', 8,2)->nullable();
			$table->float('target_margin', 18,2);
			$table->integer('financial_deviation_threshold');
			$table->integer('time_deviation_threshold');
            $table->integer('department_id')->unsigned()->nullable();

		});
	}

	public function down()
	{
		Schema::table('projects', function(Blueprint $table) {
			$table->dropForeign('projects_customer_id_foreign');
		});

		Schema::table('projects', function(Blueprint $table) {
			$table->dropForeign('projects_project_manager_id_foreign');
		});

		Schema::table('projects', function(Blueprint $table) {
			$table->dropForeign('projects_technical_director_id_foreign');
		});

		Schema::table('projects', function(Blueprint $table) {
			$table->dropForeign('projects_delivery_manager_id_foreign');
		});

		Schema::drop('projects');
	}
}