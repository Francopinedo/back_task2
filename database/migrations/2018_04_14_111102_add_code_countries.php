<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddCodeCountries extends Migration
{

    public function up()
    {


        Schema::table('countries', function (Blueprint $table) {
            $table->string('code',2)->nullable();

        });



    }

    public function down()
    {
        Schema::table('countries', function (Blueprint $table) {

            $table->dropColumn('code');
        });





    }
}