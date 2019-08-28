<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHolidaysTemplatesTable extends Migration {

	public function up()
	{
		Schema::create('holidays_templates', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->date('date');
			$table->string('description', 100);
			$table->integer('country_id')->unsigned();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
		});
	}

	public function down()
	{
        Schema::table('holidays_templates', function(Blueprint $table) {
            $table->dropForeign('holidays_templates_country_id_foreign');
        });

		Schema::drop('holidays_templates');
	}
}