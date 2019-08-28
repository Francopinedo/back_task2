<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddWekHolidaysPojects extends Migration
{

    public function up()
    {


        Schema::table('projects', function (Blueprint $table) {
            $table->text('holy_days')->nullable();

        });


    }

    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('holy_days');

        });


    }
}