<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDirectoryRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('directory_role', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('directory_id')->unsigned();
            $table->foreign('directory_id')->references('id')->on('directories')->onDelete('restrict');
			$table->integer('role_id')->unsigned();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('restrict');
            $table->boolean('read');
            $table->boolean('write');

		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('directory_role', function(Blueprint $table) {
            $table->dropForeign('directory_role_directory_id_foreign');
        });

        Schema::table('directory_role', function(Blueprint $table) {
            $table->dropForeign('directory_role_role_id_foreign');
        });

        Schema::drop('directory_role');
    }
}
