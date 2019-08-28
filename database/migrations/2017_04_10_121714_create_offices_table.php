<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOfficesTable extends Migration {

	public function up()
	{
		Schema::create('offices', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('title', 100);
			$table->integer('company_id')->unsigned();
			$table->integer('city_id')->unsigned()->nullable();
			$table->string('workinghours_from', 8)->nullable();
			$table->string('workinghours_to', 8)->nullable();
			$table->integer('hours_by_day')->unsigned()->default(8);

			$table->foreign('company_id')->references('id')->on('companies')
						->onDelete('cascade')
						->onUpdate('cascade');


		});
	}

	public function down()
	{

        Schema::table('offices', function (Blueprint $table) {
            $table->dropForeign('offices_company_id_foreign');
        });



		Schema::drop('offices');
	}
}