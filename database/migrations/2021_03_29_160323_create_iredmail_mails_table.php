<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIredmailMailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('iredmail_mails', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->string('mail', 191);
			$table->integer('iredmail_domain_id')->unsigned()->index('iredmail_mails_iredmail_domain_id_foreign');
			$table->integer('user_id')->unsigned()->index('iredmail_mails_user_id_foreign');
			$table->string('secret', 191);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('iredmail_mails');
	}

}
