<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToEmailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('emails', function(Blueprint $table)
		{
			$table->foreign('email_category_id')->references('id')->on('email_categories')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('emails', function(Blueprint $table)
		{
			$table->dropForeign('emails_email_category_id_foreign');
		});
	}

}
