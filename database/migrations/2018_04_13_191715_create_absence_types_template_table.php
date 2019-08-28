<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAbsenceTypesTemplateTable extends Migration {

	public function up()
	{
		Schema::create('absence_types_template', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('country_id')->unsigned();
            $table->foreign('country_id')->references('id')->on('countries')
                ->onDelete('restrict')
                ->onUpdate('restrict');
			$table->integer('city_id')->unsigned();
            $table->foreign('city_id')->references('id')->on('cities')
                ->onDelete('restrict')
                ->onUpdate('restrict');
			$table->string('title', 150);
			$table->tinyInteger('days');
		});
	}

	public function down()
	{

        Schema::table('absence_types_template', function (Blueprint $table) {
            $table->dropForeign('absence_types_template_country_id_foreign');
            $table->dropColumn('country_id');
        });

        Schema::table('absence_types_template', function (Blueprint $table) {
            $table->dropForeign('absence_types_template_city_id_foreign');
            $table->dropColumn('city_id');
        });


		Schema::drop('absence_types_template');
	}
}