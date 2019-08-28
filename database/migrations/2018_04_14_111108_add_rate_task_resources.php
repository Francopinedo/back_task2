<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddRateTaskResources extends Migration
{

    public function up()
    {


        Schema::table('task_resources', function (Blueprint $table) {
            $table->double('rate', 18, 2)->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('currency_id')->unsigned()->nullable();
            $table->foreign('currency_id')->references('id')->on('currencies')
                ->onDelete('restrict')
                ->onUpdate('restrict');

        });


    }

    public function down()
    {
        Schema::table('task_resources', function (Blueprint $table) {
            $table->dropColumn('rate');
            $table->dropColumn('quantity');
            $table->dropColumn('currency_id');
            $table->dropForeign('task_resources_currency_id_foreign');



        });





    }
}