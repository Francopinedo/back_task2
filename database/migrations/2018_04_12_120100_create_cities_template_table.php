<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCitiesTemplateTable extends Migration {

	public function up()
	{
		Schema::create('cities_template', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 100);
			$table->string('location_name', 100);
			$table->integer('country_id')->unsigned();
			$table->string('timezone', 150)->nullable();

            $table->foreign('country_id')->references('id')->on('countries')
                ->onDelete('restrict')
                ->onUpdate('restrict');
		});
	}

	public function down()
	{

        Schema::table('cities_template', function (Blueprint $table) {
            $table->dropForeign('cities_template_country_id_foreign');

        });

		Schema::drop('cities');
	}
}