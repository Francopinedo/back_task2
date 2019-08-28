<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class EditEngagementProjects extends Migration
{

    public function up()
    {


        Schema::table('projects', function (Blueprint $table) {

            $table->dropColumn('engagement');
        });
        Schema::table('projects', function (Blueprint $table) {
            $table->string('engagement',255)->nullable();

        });



    }

    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {

            $table->dropColumn('engagement');
        });





    }
}