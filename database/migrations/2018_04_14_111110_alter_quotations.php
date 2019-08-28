<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AlterQuotations extends Migration
{

    public function up()
    {


        Schema::table('quotations', function (Blueprint $table) {


            $table->string('number', 200);
            $table->string('concept', 200);
            $table->date('from');
            $table->date('to');
            $table->integer('contact_id')->unsigned();
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
            $table->integer('currency_id')->unsigned();
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('restrict');
            $table->date('due_date')->nullable();
            $table->float('total', 8,2);
            $table->string('bill_to', 200);
            $table->string('remit_to', 200);
            $table->boolean('emited');
            $table->text('comments');
        });


    }

    public function down()
    {
        Schema::table('quotations', function (Blueprint $table) {




        });


    }
}