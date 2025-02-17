<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToDashboardTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('dashboard', function(Blueprint $table)
		{
			$table->foreign('category')->references('id')->on('dashboard_category')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('company_id')->references('id')->on('companies')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('dashboard', function(Blueprint $table)
		{
			$table->dropForeign('dashboard_category_foreign');
			$table->dropForeign('dashboard_company_id_foreign');
		});
	}

}
