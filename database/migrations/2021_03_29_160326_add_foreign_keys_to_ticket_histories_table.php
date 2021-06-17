<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTicketHistoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ticket_histories', function(Blueprint $table)
		{
			$table->foreign('ticket_id')->references('id')->on('tickets')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ticket_histories', function(Blueprint $table)
		{
			$table->dropForeign('ticket_histories_ticket_id_foreign');
		});
	}

}
