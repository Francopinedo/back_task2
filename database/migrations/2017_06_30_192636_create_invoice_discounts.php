<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceDiscounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_discounts', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('invoice_id')->unsigned();
			$table->foreign('invoice_id')->references('id')->on('invoices');
			$table->integer('currency_id')->unsigned();
			$table->foreign('currency_id')->references('id')->on('currencies');
			$table->string('name', 150);
			$table->float('amount', 18,2);
			$table->float('percentage', 18,2);
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_discounts', function(Blueprint $table) {
            $table->dropForeign('invoice_discounts_invoice_id_foreign');
        });

        Schema::table('invoice_discounts', function(Blueprint $table) {
            $table->dropForeign('invoice_discounts_currency_id_foreign');
        });

        Schema::drop('invoice_discounts');
    }
}
