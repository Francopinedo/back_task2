<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('nombre', 255);
			$table->string('path', 255);
			$table->integer('directory_id')->unsigned();
            $table->foreign('directory_id')->references('id')->on('directories')->onDelete('restrict');


		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('contract_expenses', function(Blueprint $table) {
            $table->dropForeign('documents_directory_id_foreign');
        });



        Schema::drop('documents');
    }
}
