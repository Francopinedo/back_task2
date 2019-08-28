<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails', function(Blueprint $table) {
        	$table->increments('id');
        	$table->timestamps();
        	$table->string('title', 100);
        	$table->string('subject', 100);
        	$table->text('body');
        	$table->integer('email_category_id')->unsigned();
		});

		Schema::table('emails', function(Blueprint $table) {
			$table->foreign('email_category_id')->references('id')->on('email_categories')
						->onDelete('cascade')
						->onUpdate('cascade');
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
