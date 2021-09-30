<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLogLevelToSuSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('su_settings', function (Blueprint $table) {
            $table->text('log_level')->after('sox_audit_log');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('su_settings', function (Blueprint $table) {
            $table->dropColumn('log_level');
        });
    }
}
