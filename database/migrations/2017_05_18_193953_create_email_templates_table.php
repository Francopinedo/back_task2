<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmailTemplatesTable extends Migration {

	public function up()
	{
		Schema::create('email_templates', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('title', 100);
			$table->string('subject', 100);
			$table->text('body');
			$table->integer('email_category_template_id')->unsigned();
		});

		Schema::table('email_templates', function(Blueprint $table) {
			$table->foreign('email_category_template_id')->references('id')->on('email_category_templates')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
	}

	public function down()
	{
		Schema::drop('email_templates');
	}
}