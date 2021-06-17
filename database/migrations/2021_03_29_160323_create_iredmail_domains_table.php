<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIredmailDomainsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('iredmail_domains', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->string('domain', 191);
			$table->integer('company_id')->unsigned()->index('iredmail_domains_company_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('iredmail_domains');
	}

}
