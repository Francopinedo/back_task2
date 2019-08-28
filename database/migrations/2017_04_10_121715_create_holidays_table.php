<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHolidaysTable extends Migration {

	public function up()
	{
		Schema::create('holidays', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->date('date');
			$table->string('description', 100);
			$table->integer('country_id')->unsigned();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
			$table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
			$table->string('added_by',10);
		});
	}

	public function down()
	{
        Schema::table('holidays', function(Blueprint $table) {
            $table->dropForeign('holidays_country_id_foreign');
        });

        Schema::table('holidays', function(Blueprint $table) {
            $table->dropForeign('holidays_company_id_foreign');
        });

		Schema::drop('holidays');
	}
}