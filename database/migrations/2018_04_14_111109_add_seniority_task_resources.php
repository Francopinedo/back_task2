<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddSeniorityTaskResources extends Migration
{

    public function up()
    {


        Schema::table('task_resources', function (Blueprint $table) {

            $table->integer('seniority_id')->unsigned()->nullable();
            $table->foreign('seniority_id')->references('id')->on('seniorities')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });


    }

    public function down()
    {
        Schema::table('task_resources', function (Blueprint $table) {

            $table->dropColumn('seniority_id');
            $table->dropForeign('task_resources_seniority_id_foreign');


        });


    }
}