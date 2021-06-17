<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToIredmailMailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('iredmail_mails', function(Blueprint $table)
		{
			$table->foreign('iredmail_domain_id')->references('id')->on('iredmail_domains')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('iredmail_mails', function(Blueprint $table)
		{
			$table->dropForeign('iredmail_mails_iredmail_domain_id_foreign');
			$table->dropForeign('iredmail_mails_user_id_foreign');
		});
	}

}
