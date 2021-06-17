<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProcurementOffersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('procurement_offers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->string('description', 180);
			$table->text('specifications', 65535);
			$table->boolean('delivery_max_days_offered');
			$table->integer('delivery_responsable')->unsigned()->index('procurement_offers_delivery_responsable_foreign');
			$table->float('cost', 18);
			$table->string('quality', 180);
			$table->integer('provider_id')->unsigned();
			$table->string('comment', 180);
			$table->integer('procurement_id')->unsigned()->index('procurement_offers_procurement_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('procurement_offers');
	}

}
