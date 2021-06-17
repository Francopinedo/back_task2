<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWorkflowsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('workflows', function(Blueprint $table)
		{
			$table->integer('customer_id')->comment('customer code');
			$table->integer('project_id')->comment('project code');
			$table->string('workflow_id', 15)->comment('workflow hierarchy id (ie 001.000.000.000)');
			$table->string('group_name', 30)->comment('ie. Approvals, Quality, Legal, etc');
			$table->string('workflow_name', 30)->comment('ie. Billing Approvals');
			$table->date('start_date')->comment('starting date for this workflow (if any)');
			$table->date('due_date')->comment('due date for this workflow (if any)');
			$table->integer('created_by')->comment('Creator of this workflow');
			$table->date('last_run')->comment('date & time of last run or checking for this workflow');
			$table->decimal('minutes_run_frequency', 10, 0)->comment('Minutes Run Frequency (ie. will run each  60 minutes)');
			$table->enum('framework', array('Fixed  Price','Staff Augmentation','Maintenance','SLA','Consultancy','Agile'));
			$table->integer('owner')->comment('user id (owner of this workflow now)');
			$table->integer('destiny')->comment('confirmar data type, porque puede ser enviado a uno o varios  usuario, a uno o varios workgroups id');
			$table->boolean('notify_owner')->comment('notify owner yes or no');
			$table->string('note', 80)->comment('ie."worflow for billing approval"');
			$table->enum('action', array('FullFill Form','Send Email','FullFill Form & Send by Email','Schedule a Meeting Schedule'))->comment('a reference to other workflow id or process menu');
			$table->enum('status', array('Not Started Yet','Executing','Waiting Input','Overdue','Finished','Canceled'));
			$table->string('condition_name', 40)->comment('ie Was this expense report approved by the delivery manager?');
			$table->boolean('success_unsuccess')->comment('if conditional is sucess or unsuccess (1= sucess, 0=unsuccess)');
			$table->string('ifsuccessgoto', 12)->comment('if conditional is t true go to specific workflow _id');
			$table->string('ifunsuccessgoto', 12)->comment('if conditional not true goto specific worfklow id');
			$table->boolean('owner_alerted')->comment('owner already alerted yes or no');
			$table->string('attachment', 180)->comment('forms to be fullfilled or to be send');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('workflows');
	}

}
