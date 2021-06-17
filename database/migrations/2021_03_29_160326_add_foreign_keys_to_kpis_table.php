<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToKpisTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('kpis', function(Blueprint $table)
		{
			$table->foreign('category')->references('id')->on('kpis_category')->onUpdate('RESTRICT')->onDelete('RESTRICT');
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
		Schema::table('kpis', function(Blueprint $table)
		{
			$table->dropForeign('kpis_category_foreign');
			$table->dropForeign('kpis_company_id_foreign');
		});
	}

}
