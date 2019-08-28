<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetadocuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metadocu', function (Blueprint $table) {
            $table->integer('language')->unsigned();
            $table->foreign('language')->references('id')->on('languages')->onDelete('restrict');
            $table->integer('activity')->unsigned();
            $table->foreign('activity')->references('id')->on('activities')->onDelete('restrict');
            $table->integer('document_type')->unsigned();
            $table->foreign('document_type')->references('id')->on('doctypes')->onDelete('restrict');
            $table->integer('code')->unsigned();
            $table->integer('version')->unsigned();
            $table->string('name', 255);
            $table->string('link_logo_left', 255);
            $table->string('link_logo_right', 255);
            $table->string('path_ref', 255)->comment="Esta columna es solo de referencia, seria el nombre del archivo final. Tendra que ser compatible con el archivo a cargar.";
            $table->integer('document_id')->unsigned();
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('restrict');

            $keys = array('language', 'activity', 'document_type','code','version');
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
        Schema::table('metadocu', function (Blueprint $table) {
            $table->dropForeign('metadocu_language_foreign');
        });

        Schema::table('metadocu', function (Blueprint $table) {
            $table->dropForeign('metadocu_activity_foreign');
        });
        Schema::table('metadocu', function (Blueprint $table) {
            $table->dropForeign('metadocu_document_type_foreign');
        });
        Schema::table('metadocu', function (Blueprint $table) {
            $table->dropForeign('metadocu_document_id_foreign');
        });

        Schema::drop('metadocu');
    }
}
