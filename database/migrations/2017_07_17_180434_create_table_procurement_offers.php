<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProcurementOffers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procurement_offers', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('description', 180);
			$table->text('specifications');
			$table->tinyInteger('delivery_max_days_offered');
			$table->integer('delivery_responsable')->unsigned();
			$table->foreign('delivery_responsable')->references('id')->on('users')->onDelete('restrict');
			$table->float('cost', 18,2);
			$table->string('quality', 180);
			$table->integer('provider_id')->unsigned();

			$table->string('comment', 180);
			$table->integer('procurement_id')->unsigned();
			$table->foreign('procurement_id')->references('id')->on('procurements')->onDelete('restrict');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('procurement_offers', function (Blueprint $table) {
            $table->dropForeign('procurement_offers_delivery_responsable_foreign');
        });

        Schema::table('procurement_offers', function (Blueprint $table) {
            $table->dropForeign('procurement_offers_provider_id_foreign');
        });

        Schema::table('procurement_offers', function (Blueprint $table) {
            $table->dropForeign('procurement_provider_procurement_id_foreign');
        });


        Schema::drop('procurement_offers');
    }
}
