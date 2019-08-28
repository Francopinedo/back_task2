<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InvoiceResources extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_resources', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('invoice_id')->unsigned();
			$table->foreign('invoice_id')->references('id')->on('invoices');
			$table->integer('project_role_id')->unsigned();
			$table->foreign('project_role_id')->references('id')->on('project_roles')->onDelete('restrict');
			$table->integer('seniority_id')->unsigned();
			$table->foreign('seniority_id')->references('id')->on('seniorities')->onDelete('restrict');
			$table->integer('currency_id')->unsigned();
			$table->foreign('currency_id')->references('id')->on('currencies')->onDelete('restrict');
			$table->tinyInteger('load');
			$table->enum('workplace', array('onsite', 'offshore'));
			$table->float('rate', 18,2);
            $table->integer('rate_id')->unsigned()->nullable();
            $table->foreign('rate_id')->references('id')->on('rates')->onDelete('restrict');
			$table->integer('hours');
			$table->string('type', 190);
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');
			$table->text('comments')->nullable();
            $table->integer('office_id')->unsigned();
            $table->foreign('office_id')->references('id')->on('offices');

            $table->integer('country_id')->unsigned();
            $table->foreign('country_id')->references('id')->on('countries');
            $table->integer('city_id')->unsigned();
            $table->foreign('city_id')->references('id')->on('cities');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('invoice_resources', function(Blueprint $table) {
            $table->dropForeign('invoice_resourcess_invoice_id_foreign');
        });

        Schema::table('invoice_resources', function(Blueprint $table) {
            $table->dropForeign('invoice_resources_currency_id_foreign');
        });

        Schema::table('invoice_resources', function(Blueprint $table) {
            $table->dropForeign('invoice_resources_project_role_id_foreign');
        });


        Schema::table('invoice_resources', function(Blueprint $table) {
            $table->dropForeign('invoice_resources_seniority_id_foreign');
        });

        Schema::table('invoice_resources', function(Blueprint $table) {
            $table->dropForeign('invoice_resources_rate_id_foreign');
        });


        Schema::drop('invoice_resources');
    }
}
