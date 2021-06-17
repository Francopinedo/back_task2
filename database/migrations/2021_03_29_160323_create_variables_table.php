<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVariablesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('variables', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('document_id')->unsigned()->index('document_id')->comment('Documento o versión de documento asociado');
			$table->integer('metavariable_id')->index('metavariable_id')->comment('metavariable asociada');
			$table->text('value', 65535)->comment('valor guardado');
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('variables');
	}

}
