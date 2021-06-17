<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToQuotationLinesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('quotation_lines', function(Blueprint $table)
		{
			$table->foreign('quotation_id')->references('id')->on('quotations')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('quotation_lines', function(Blueprint $table)
		{
			$table->dropForeign('quotation_lines_quotation_id_foreign');
		});
	}

}
