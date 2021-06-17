<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateKpisTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('kpis', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('company_id')->unsigned()->index('kpis_company_id_foreign');
			$table->integer('category')->unsigned()->nullable()->index('kpis_category_foreign');
			$table->text('description', 65535);
			$table->string('query', 200);
			$table->string('graphic_type')->nullable();
			$table->string('nombre')->nullable();
			$table->string('kpi')->nullable();
			$table->string('type_of_result')->nullable();
			$table->integer('showkpi');
			$table->integer('showdashboard')->default(1);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('kpis');
	}

}
