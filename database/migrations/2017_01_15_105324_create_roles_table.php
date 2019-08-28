<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('description')->nullable();
            $table->integer('level')->default(1);
            $table->timestamps();
            $table->integer('company_role_id')->unsigned()->nullable()->default(NULL);
            $table->foreign('company_role_id')->references('id')->on('company_roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {


        Schema::table('roles', function(Blueprint $table) {
            $table->dropForeign('roles_company_role_id_foreign');
        });


        Schema::dropIfExists('roles');
    }
}