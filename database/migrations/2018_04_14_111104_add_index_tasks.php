<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddIndexTasks extends Migration
{

    public function up()
    {


        Schema::table('tasks', function (Blueprint $table) {
            $table->integer('index')->nullable();

        });



    }

    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {

            $table->dropColumn('index');
        });





    }
}