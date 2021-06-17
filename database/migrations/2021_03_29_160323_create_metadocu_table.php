<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMetadocuTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('metadocu', function(Blueprint $table)
		{
			$table->integer('language')->unsigned();
			$table->integer('activity')->unsigned()->index('metadocu_activity_foreign');
			$table->integer('document_type')->unsigned()->index('metadocu_document_type_foreign');
			$table->integer('code')->unsigned();
			$table->integer('version')->unsigned();
			$table->string('name');
			$table->string('link_logo_left');
			$table->string('link_logo_right');
			$table->string('path_ref')->comment('Esta columna es solo de referencia, seria el nombre del archivo final. Tendra que ser compatible con el archivo a cargar.');
			$table->integer('document_id')->unsigned()->index('metadocu_document_id_foreign');
			$table->primary(['language','activity','document_type','code','version']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('metadocu');
	}

}
