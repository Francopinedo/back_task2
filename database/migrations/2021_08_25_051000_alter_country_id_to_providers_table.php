<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCountryIdToProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('providers', function (Blueprint $table) {
            $table->dropColumn('country_id');
        });
        Schema::table('providers', function (Blueprint $table) {
            $table->integer('country_id')->unsigned()->nullable()->index('providers_country_id_foreign')->after('address');
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
        Schema::table('providers', function (Blueprint $table) {
            $table->dropForeign('providers_country_id_foreign');
            $table->dropColumn('country_id');
        });
        Schema::table('providers', function (Blueprint $table) {
            $table->integer('country_id')->default(0)->after('address');
        });
    }
}
