<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_services', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('quotation_id')->unsigned();
			$table->foreign('quotation_id')->references('id')->on('quotations');
            $table->string('detail', 150);
            $table->float('amount', 18,2);
            $table->float('cost', 18,2);

			$table->integer('currency_id')->unsigned();
			$table->foreign('currency_id')->references('id')->on('currencies');


		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('quotation_services', function(Blueprint $table) {
            $table->dropForeign('quotation_services_quotation_d_foreign');
        });


        Schema::table('quotation_services', function(Blueprint $table) {
            $table->dropForeign('quotation_services_currency_id_foreign');
        });

        Schema::drop('quotation_services');
    }
}
