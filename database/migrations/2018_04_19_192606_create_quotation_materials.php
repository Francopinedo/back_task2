<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationMaterials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_materials', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('quotation_id')->unsigned();
			$table->foreign('quotation_id')->references('id')->on('quotations');
			$table->integer('currency_id')->unsigned();
			$table->foreign('currency_id')->references('id')->on('currencies');
			$table->string('detail', 150);
			$table->float('cost', 18,2);
			$table->float('amount', 18,2);
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('quotation_materials', function(Blueprint $table) {
            $table->dropForeign('quotation_materials_quotation_id_foreign');
        });

        Schema::table('quotation_materials', function(Blueprint $table) {
            $table->dropForeign('quotation_materials_currency_id_foreign');
        });

        Schema::drop('quotation_materials');
    }
}
