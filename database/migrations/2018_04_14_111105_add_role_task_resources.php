<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddRoleTaskResources extends Migration
{

    public function up()
    {


        Schema::table('task_resources', function (Blueprint $table) {
            $table->integer('project_role_id')->unsigned()->nullable();
            $table->foreign('project_role_id')->references('id')->on('project_roles')->onDelete('restrict');

        });



    }

    public function down()
    {
        Schema::table('task_resources', function (Blueprint $table) {
            $table->dropForeign('task_resources_project_role_id_foreign');
            $table->dropColumn('project_role_id');
        });





    }
}