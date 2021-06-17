<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDashboardCategoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dashboard_category', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 100);
			$table->integer('company_id')->unsigned()->index('dashboard_category_company_id_foreign');
			$table->string('roles', 100)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('dashboard_category');
	}

}
