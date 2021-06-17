<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMetavariableKindsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('metavariable_kinds', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('code', 10)->comment('Código único (letra o letras) que identifican un tipo dentro de un documento');
			$table->string('name_es')->comment('Nombre en español');
			$table->string('name_en')->comment('Nombre en inglés');
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
		Schema::drop('metavariable_kinds');
	}

}
