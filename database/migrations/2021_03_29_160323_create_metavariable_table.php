<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMetavariableTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('metavariable', function(Blueprint $table)
		{
			$table->integer('language')->unsigned();
			$table->integer('activity')->unsigned()->index('metavariable_activity_foreign');
			$table->integer('document_type')->unsigned()->index('metavariable_document_type_foreign');
			$table->integer('code')->unsigned();
			$table->integer('version')->unsigned();
			$table->integer('variable_code')->unsigned();
			$table->integer('variable_type')->unsigned();
			$table->string('variable_name');
			$table->string('caption');
			$table->string('image_link');
			$table->string('hyperlink_link');
			$table->string('dependencies');
			// $table->primary(['language','activity','document_type','code','version','variable_code']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('metavariable');
	}

}
