<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateKpisCategoryTable extends Migration {

	public function up()
	{
		Schema::create('kpis_category', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 100);
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies')
                ->onDelete('restrict')
                ->onUpdate('restrict');
		});


        Schema::table('kpis', function (Blueprint $table) {

            $table->integer('category')->unsigned()->nullable()->change();
            $table->foreign('category')->references('id')->on('kpis_category')
                ->onDelete('restrict')
                ->onUpdate('restrict');

        });
	}

	public function down()
	{
		Schema::drop('kpis_category');
	}
}