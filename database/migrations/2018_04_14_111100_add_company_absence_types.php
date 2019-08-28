<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddCompanyAbsenceTypes extends Migration
{

    public function up()
    {


        Schema::table('absence_types', function (Blueprint $table) {
            $table->integer('company_id')->unsigned()->nullable();
                $table->foreign('company_id')->references('id')->on('companies')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });


    }

    public function down()
    {
        Schema::table('absence_types', function (Blueprint $table) {
            $table->dropForeign('absence_types_company_id_foreign');
            $table->dropColumn('company_id');
        });





    }
}