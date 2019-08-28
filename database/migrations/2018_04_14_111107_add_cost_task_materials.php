<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddCostTaskMaterials extends Migration
{

    public function up()
    {


        Schema::table('task_materials', function (Blueprint $table) {
            $table->double('cost', 18, 2)->nullable();
            $table->double('amount', 18, 2)->nullable();
            $table->boolean('reimbursable')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('currency_id')->unsigned()->nullable();
            $table->foreign('currency_id')->references('id')->on('currencies')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });

        Schema::table('task_services', function (Blueprint $table) {
            $table->double('cost', 18, 2)->nullable();
            $table->double('amount', 18, 2)->nullable();
            $table->boolean('reimbursable')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('currency_id')->unsigned()->nullable();
            $table->foreign('currency_id')->references('id')->on('currencies')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });


    }

    public function down()
    {
        Schema::table('task_materials', function (Blueprint $table) {
            $table->dropColumn('cost');
            $table->dropColumn('amount');
            $table->dropColumn('reimbursable');
            $table->dropColumn('quantity');
            $table->dropColumn('currency_id');

            $table->dropForeign('task_materials_currency_id_foreign');

        });

        Schema::table('task_services', function (Blueprint $table) {
            $table->dropColumn('cost');
            $table->dropColumn('amount');
            $table->dropColumn('reimbursable');
            $table->dropColumn('quantity');
            $table->dropColumn('currency_id');

            $table->dropForeign('task_services_currency_id_foreign');

        });



    }
}