<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToStakeholdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('stakeholders', function(Blueprint $table)
		{
			$table->foreign('contact_id')->references('id')->on('contacts')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('stakeholders', function(Blueprint $table)
		{
			$table->dropForeign('stakeholders_contact_id_foreign');
		});
	}

}
