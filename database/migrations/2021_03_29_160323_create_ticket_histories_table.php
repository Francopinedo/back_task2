<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTicketHistoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ticket_histories', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('ticket_id')->unsigned()->index('ticket_histories_ticket_id_foreign');
			$table->date('date');
			$table->enum('internal_or_external', array('internal','external'));
			$table->string('comment', 180);
			$table->integer('owner_id')->unsigned()->index('ticket_histories_owner_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ticket_histories');
	}

}
