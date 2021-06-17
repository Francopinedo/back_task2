<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToMetadocuTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('metadocu', function(Blueprint $table)
		{
			$table->foreign('activity')->references('id')->on('activities')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('document_id')->references('id')->on('documents')->onUpdate('RESTRICT')->onDelete('RESTRICT');
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
		Schema::table('metadocu', function(Blueprint $table)
		{
			$table->dropForeign('metadocu_activity_foreign');
			$table->dropForeign('metadocu_document_id_foreign');
			$table->dropForeign('metadocu_document_type_foreign');
			$table->dropForeign('metadocu_language_foreign');
		});
	}

}
