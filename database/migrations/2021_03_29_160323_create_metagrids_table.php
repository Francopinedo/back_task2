<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMetagridsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('metagrids', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('metadocument_id')->index('metadocument_id')->comment('ID Metadocumento');
			$table->text('name', 65535)->comment('Nombre de la tabla (sólo referencial)');
			$table->string('caption')->nullable();
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
		Schema::drop('metagrids');
	}

}
