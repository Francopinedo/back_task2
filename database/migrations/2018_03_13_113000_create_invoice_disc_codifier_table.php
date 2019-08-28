<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceDiscCodifierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_disc_codifier', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('discount_id')->unsigned();
            $table->foreign('discount_id')->references('id')->on('discounts')->onDelete('restrict');
			$table->integer('currency_id')->unsigned();
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('restrict');
            $table->string('name', 150);
            $table->float('percentage', 18, 2);
            $table->tinyInteger('overfield');

		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_disc_codifier', function(Blueprint $table) {
            $table->dropForeign('invoice_disc_codifier_discount_id_foreign');
        });

        Schema::table('invoice_disc_codifier', function(Blueprint $table) {
            $table->dropForeign('invoice_disc_codifier_currency_id_foreign');
        });

        Schema::drop('invoice_disc_codifier');
    }
}
