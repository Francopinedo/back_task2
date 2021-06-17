<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('emails', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->string('title', 100);
			$table->string('subject', 100);
			$table->text('body', 65535);
			$table->integer('email_category_id')->unsigned()->index('emails_email_category_id_foreign');
			$table->string('added_by', 10)->nullable();
			$table->integer('user_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('emails');
	}

}
