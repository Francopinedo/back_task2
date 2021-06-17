<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToMetagridsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('metagrids', function(Blueprint $table)
		{
			$table->foreign('metadocument_id', 'metagrids_ibfk_1')->references('id')->on('metadocuments')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('metagrids', function(Blueprint $table)
		{
			$table->dropForeign('metagrids_ibfk_1');
		});
	}

}
