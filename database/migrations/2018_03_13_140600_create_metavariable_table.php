<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetavariableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metavariable', function (Blueprint $table) {
            $table->integer('language')->unsigned();
            $table->foreign('language')->references('id')->on('languages')->onDelete('restrict');
            $table->integer('activity')->unsigned();
            $table->foreign('activity')->references('id')->on('activities')->onDelete('restrict');
            $table->integer('document_type')->unsigned();
            $table->foreign('document_type')->references('id')->on('doctypes')->onDelete('restrict');
            $table->integer('code')->unsigned();
            $table->integer('version')->unsigned();
            $table->integer('variable_code')->unsigned()->comments="A unique sequential number within this template";
            $table->integer('variable_type')->unsigned()->comments="T, P, N, F, D, I, L, HL, GNxM, GNxMTR, GNxMTC, GNxMTRC";
            $table->string('variable_name', 255);
            $table->string('caption', 255);
            $table->string('image_link', 255)->comments="Para datatype imagen";
            $table->string('hyperlink_link', 255)->comments="Para datatype imagen";
            $table->string('dependencies', 255);

            $keys = array('language', 'activity', 'document_type','code','version','variable_code');
            $table->primary($keys, 'pk');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('metavariable', function (Blueprint $table) {
            $table->dropForeign('metavariable_language_foreign');
        });

        Schema::table('metavariable', function (Blueprint $table) {
            $table->dropForeign('metavariable_activity_foreign');
        });
        Schema::table('metavariable', function (Blueprint $table) {
            $table->dropForeign('metavariable_document_type_foreign');
        });
        Schema::table('metavariable', function (Blueprint $table) {
            $table->dropForeign('metavariable_document_id_foreign');
        });

        Schema::drop('metavariable');
    }
}
