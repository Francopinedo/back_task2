<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStakeholdersTable extends Migration {

	public function up()
	{
		Schema::create('stakeholders', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->enum('influence', array('high', 'medium', 'low'));
			$table->text('impacted');
			$table->text('impact');
			$table->text('expectations');
			$table->integer('contact_id')->unsigned();

			$table->foreign('contact_id')->references('id')->on('contacts')
						->onDelete('cascade');
		});
	}

	public function down()
	{
		Schema::table('stakeholders', function(Blueprint $table) {
			$table->dropForeign('stakeholders_contact_id_foreign');
		});

		Schema::drop('stakeholders');
	}
}