<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities_history', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('agenda_id')->unsigned();
			$table->foreign('agenda_id')->references('id')->on('agenda')->onDelete('cascade');
			$table->datetime('date');
			$table->text('description');
			$table->integer('follower_id')->unsigned();
			$table->foreign('follower_id')->references('id')->on('users')->onDelete('cascade');
			$table->datetime('due');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activities_history', function(Blueprint $table) {
			$table->dropForeign('activities_history_agenda_id_foreign');
		});

		Schema::table('activities_history', function(Blueprint $table) {
			$table->dropForeign('activities_history_follower_id_foreign');
		});

		Schema::drop('activities_history');
    }
}
