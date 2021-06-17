<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMetagridTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('metagrid', function(Blueprint $table)
		{
			$table->integer('language')->unsigned();
			$table->integer('activity')->unsigned()->index('metagrid_activity_foreign');
			$table->integer('document_type')->unsigned()->index('metagrid_document_type_foreign');
			$table->integer('code')->unsigned();
			$table->integer('version')->unsigned();
			$table->integer('variable_code')->unsigned();
			$table->string('caption');
			$table->integer('row_number');
			$table->integer('column_number');
			$table->string('column_name');
			$table->string('column_type', 2)->comment('T, P, N, D, I, L, HL');
			$table->string('image_link', 2)->comment('Para datatype imagen');
			$table->string('hyperlink_link', 2)->comment('Para datatype link o hyperlink');
			$table->primary(['language','activity','document_type','code','version','variable_code','row_number','column_number']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('metagrid');
	}

}
