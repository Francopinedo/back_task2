<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterColumnActivityIdToMetadocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('metadocuments', function (Blueprint $table) {
            $table->renameColumn('activity_id', 'industry_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('metadocuments', function (Blueprint $table) {
            $table->renameColumn('industry_id', 'activity_id')->change();
        });
    }
}
