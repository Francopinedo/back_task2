<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMetadocumentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('metadocuments', function(Blueprint $table)
		{
			$table->integer('id');
			$table->integer('language_id')->unsigned();
			$table->integer('activity_id')->unsigned();
			$table->integer('doctype_id')->unsigned();
			$table->integer('code')->unsigned();
			$table->integer('version')->unsigned();
			$table->string('name');
			$table->string('link_logo_left')->nullable();
			$table->string('link_logo_right')->nullable();
			$table->string('path_ref')->comment('Esta columna es solo de referencia, seria el nombre del archivo final. Tendra que ser compatible con el archivo a cargar.');
			$table->integer('document_id')->unsigned()->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->primary(['id','language_id','activity_id','doctype_id','version'], 'metadocuments_primary');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('metadocuments');
	}

}
