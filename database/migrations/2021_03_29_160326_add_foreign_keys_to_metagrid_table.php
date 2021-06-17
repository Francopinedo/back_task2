<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToMetagridTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('metagrid', function(Blueprint $table)
		{
			$table->foreign('activity')->references('id')->on('activities')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('document_type')->references('id')->on('doctypes')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('language')->references('id')->on('languages')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('metagrid', function(Blueprint $table)
		{
			$table->dropForeign('metagrid_activity_foreign');
			$table->dropForeign('metagrid_document_type_foreign');
			$table->dropForeign('metagrid_language_foreign');
		});
	}

}
