<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToProcurementOffersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('procurement_offers', function(Blueprint $table)
		{
			$table->foreign('delivery_responsable')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('procurement_id')->references('id')->on('procurements')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('procurement_offers', function(Blueprint $table)
		{
			$table->dropForeign('procurement_offers_delivery_responsable_foreign');
			$table->dropForeign('procurement_offers_procurement_id_foreign');
		});
	}

}
