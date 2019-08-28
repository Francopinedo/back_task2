<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetagridTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metagrid', function (Blueprint $table) {
            $table->integer('language')->unsigned();
            $table->foreign('language')->references('id')->on('languages')->onDelete('restrict');
            $table->integer('activity')->unsigned();
            $table->foreign('activity')->references('id')->on('activities')->onDelete('restrict');
            $table->integer('document_type')->unsigned();
            $table->foreign('document_type')->references('id')->on('doctypes')->onDelete('restrict');
            $table->integer('code')->unsigned();
            $table->integer('version')->unsigned();
            $table->integer('variable_code')->unsigned();
            $table->string('caption', 255);
            $table->integer('row_number');
            $table->integer('column_number');
            $table->string('column_name', 255);
            $table->string('column_type', 2)->comment='T, P, N, D, I, L, HL';
            $table->string('image_link', 2)->comment='Para datatype imagen';
            $table->string('hyperlink_link', 2)->comment='Para datatype link o hyperlink';

            $keys = array('language', 'activity', 'document_type','code','version','variable_code','row_number','column_number');
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
        Schema::table('metagrid', function (Blueprint $table) {
            $table->dropForeign('metadocu_language_foreign');
        });

        Schema::table('metagrid', function (Blueprint $table) {
            $table->dropForeign('metadocu_activity_foreign');
        });
        Schema::table('metagrid', function (Blueprint $table) {
            $table->dropForeign('metadocu_document_type_foreign');
        });


        Schema::drop('metagrid');
    }
}
