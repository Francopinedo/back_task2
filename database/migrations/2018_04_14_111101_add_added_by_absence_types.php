<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddAddedByAbsenceTypes extends Migration
{

    public function up()
    {


        Schema::table('absence_types', function (Blueprint $table) {
            $table->string('added_by',10)->nullable();

        });

        Schema::table('cities', function (Blueprint $table) {
            $table->string('added_by',10)->nullable();

        });


    }

    public function down()
    {
        Schema::table('absence_types', function (Blueprint $table) {

            $table->dropColumn('added_by');
        });

        Schema::table('cities', function (Blueprint $table) {

            $table->dropColumn('added_by');
        });





    }
}