<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddAddedByEmails extends Migration
{

    public function up()
    {


        Schema::table('emails', function (Blueprint $table) {
            $table->string('added_by',10)->nullable();

        });

        Schema::table('email_categories', function (Blueprint $table) {
            $table->string('added_by',10)->nullable();

        });


    }

    public function down()
    {
        Schema::table('emails', function (Blueprint $table) {

            $table->dropColumn('added_by');
        });

        Schema::table('email_categories', function (Blueprint $table) {

            $table->dropColumn('added_by');
        });





    }





}