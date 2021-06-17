<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToVariablesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('variables', function(Blueprint $table)
		{
			$table->foreign('document_id', 'variables_ibfk_1')->references('id')->on('documents')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('metavariable_id', 'variables_ibfk_2')->references('id')->on('metavariables')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('variables', function(Blueprint $table)
		{
			$table->dropForeign('variables_ibfk_1');
			$table->dropForeign('variables_ibfk_2');
		});
	}

}
