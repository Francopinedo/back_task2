<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAuditLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('audit_log', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->dateTime('date_action')->nullable()->comment('Date of the Action');
			$table->text('process_name', 65535)->nullable()->comment('ie. Adjustments');
			$table->string('action_name', 100)->nullable()->comment('ie. Add debts or Add  Credits adjustements');
			$table->integer('user_id')->nullable()->comment('just the user id executing the action');
			$table->text('user_name', 65535)->nullable();
			$table->string('user_comment', 80)->nullable();
			$table->string('reason', 80)->nullable()->comment('why the user is executing this action');
			$table->text('business_rule', 65535)->nullable();
			$table->integer('customer_id')->nullable();
			$table->integer('project_id')->nullable();
			$table->text('role', 65535)->nullable();
			$table->text('action', 65535)->nullable();
			$table->text('table_name', 65535)->nullable();
			$table->text('field', 65535)->nullable();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('audit_log');
	}

}
