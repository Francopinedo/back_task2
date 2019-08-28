<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_histories', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('ticket_id')->unsigned();
			$table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('restrict');
			$table->date('date');
			$table->enum('internal_or_external', array('internal', 'external'));
			$table->string('comment', 180);
			$table->integer('owner_id')->unsigned();
			$table->foreign('owner_id')->references('id')->on('users')->onDelete('restrict');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ticket_histories', function(Blueprint $table) {
            $table->dropForeign('ticket_histories_ticket_id_foreign');
        });

        Schema::table('ticket_histories', function(Blueprint $table) {
            $table->dropForeign('ticket_histories_owner_id_foreign');
        });

        Schema::drop('ticket_histories');
    }
}
