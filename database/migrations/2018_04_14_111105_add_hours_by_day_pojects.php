<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddHoursByDayPojects extends Migration
{

    public function up()
    {


        Schema::table('projects', function (Blueprint $table) {
            $table->integer('hours_by_day')->unsigned()->nullable();


        });


    }

    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('hours_by_day');
        });


    }
}