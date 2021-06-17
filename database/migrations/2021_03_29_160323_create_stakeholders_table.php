<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStakeholdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('stakeholders', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->enum('influence', array('high','medium','low'));
			$table->text('impacted', 65535);
			$table->text('impact', 65535);
			$table->text('expectations', 65535);
			$table->integer('contact_id')->unsigned()->index('stakeholders_contact_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('stakeholders');
	}

}
