<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateKpisTable extends Migration {

	public function up()
	{
		Schema::create('kpis', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('company_id')->unsigned();
			$table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
			$table->string('category', 100);
			$table->string('graphic_type', 255);
			$table->string('nombre', 255);
			$table->string('kpi', 255);
			$table->string('type_of_result', 255);
			$table->text('description');
			$table->string('query', 200);

		});
	}

	public function down()
	{
		Schema::table('kpis', function(Blueprint $table) {
			$table->dropForeign('kpis_company_id_foreign');
		});

		Schema::drop('kpis');
	}
}