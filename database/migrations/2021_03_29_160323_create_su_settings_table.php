<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSuSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('su_settings', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('plugins_enabled')->comment('0= No 1=Yes');
			$table->integer('workflows_enabled')->comment('0= No 1=Yes');
			$table->integer('payments_enabled')->comment('0= No 1=Yes');
			$table->integer('wiki_enabled')->comment('0= No 1=Yes');
			$table->integer('mail_server_enable')->default(1);
			$table->text('mail_server_protocol', 65535)->comment('smtp (default)');
			$table->text('mail_server_encryption', 65535)->comment('ssl (default)');
			$table->text('mail_server_hosts', 65535)->comment('mail servers ips separted with ;');
			$table->integer('mail_server_port')->comment('25 default smtp port');
			$table->text('mail_server_user', 65535);
			$table->text('mail_server_pass', 65535);
			$table->string('mail_server_from_email', 45)->comment('mail from');
			$table->integer('chat_server_enable')->default(1);
			$table->text('chat_server_url', 65535)->nullable();
			$table->integer('payment_integration');
			$table->string('payment_gateway', 100)->nullable();
			$table->integer('digital_signature')->default(0);
			$table->integer('cloud_storage')->default(0);
			$table->string('cloud_storage_provider', 100)->nullable();
			$table->integer('task_creation_email')->default(0);
			$table->integer('social_media')->default(0);
			$table->integer('fields_add_feature')->default(0);
			$table->integer('alfred_active')->default(0);
			$table->integer('field_captions')->default(0);
			$table->integer('system_log')->default(1);
			$table->integer('sox_audit_log')->default(1);
			$table->integer('process_group_active')->default(1);
			$table->integer('knowledge_areas_active')->default(1);
			$table->string('version', 20)->nullable();
			$table->integer('max_users')->default(0);
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
		Schema::drop('su_settings');
	}

}
