<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMetavariablesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('metavariables', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('metavariable_kind_id')->index('metavariable_kind_id')->comment('Tipo de variable');
			$table->text('name', 65535)->nullable()->comment('Valor de la variable');
			$table->string('caption')->nullable();
			$table->string('dependencies')->nullable();
			$table->integer('metadocument_id')->nullable()->index('metadocument_id')->comment('Id a documento asociado');
			$table->integer('width')->nullable()->default(50)->comment('Porcentaje de ancho del campo en formulario');
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
		Schema::drop('metavariables');
	}

}
