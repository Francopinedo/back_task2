<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *2017_04_10_185223_create_departments_table
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function(Blueprint $table) {
        	$table->increments('id');
        	$table->timestamps();
        	$table->integer('office_id')->unsigned();
        	$table->string('title', 100);

			$table->foreign('office_id')->references('id')->on('offices')
						->onDelete('cascade')
						->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('departments');
    }
}
