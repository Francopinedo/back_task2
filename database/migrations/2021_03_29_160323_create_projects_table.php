<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProjectsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('projects', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 200);
			$table->integer('customer_id')->unsigned()->index('projects_customer_id_foreign');
			$table->string('customer_name', 150);
			$table->date('start');
			$table->date('finish');
			$table->integer('project_manager_id')->unsigned()->nullable()->index('projects_project_manager_id_foreign');
			$table->integer('technical_director_id')->unsigned()->nullable()->index('projects_technical_director_id_foreign');
			$table->integer('delivery_manager_id')->unsigned()->nullable()->index('projects_delivery_manager_id_foreign');
			$table->string('sow_number', 150);
			$table->string('identificator', 100)->nullable();
			$table->enum('status', array('Initiating','Planning','Executing','Closing','Waiting'));
			$table->string('presales_responsable', 150);
			$table->string('technical_estimator', 150);
			$table->float('estimated_revenue', 18);
			$table->float('estimated_cost', 18);
			$table->float('estimated_margin', 18);
			$table->float('estimated_department_margin')->nullable();
			$table->float('target_margin', 18);
			$table->integer('financial_deviation_threshold');
			$table->integer('scope_deviation_threshold');
			$table->integer('quality_deviation_threshold');
			$table->integer('time_deviation_threshold');
			$table->integer('department_id')->unsigned()->nullable()->index('projects_department_id_foreign');
			$table->string('engagement')->nullable();
			$table->integer('hours_by_day')->unsigned()->nullable();
			$table->text('holy_days', 65535)->nullable();
			$table->text('name_convention')->comment('Name Conventions for the Repository Documents');
			$table->binary('audit_log', 1)->comment('0= No Log Generation 1= Log Generation');
			$table->boolean('create_task_from_email', 1)->comment('0= Not create 1= Create');
			$table->boolean('digital_signature_enabled', 1)->comment('0=Not Enabled 1= Enabled');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('projects');
	}

}
