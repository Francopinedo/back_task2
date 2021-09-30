<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCountryIdToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('country_id');
        });
        Schema::table('users', function(Blueprint $table) {
            $table->integer('country_id')->unsigned()->nullable()->index('users_country_id_foreign')->after('cell_phone');
            $table->foreign('country_id')->references('id')->on('countries')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_country_id_foreign');
            $table->dropColumn('country_id');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->integer('country_id')->nullable()->after('cell_phone');
        });
    }
}
