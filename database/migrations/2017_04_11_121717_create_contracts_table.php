<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContractsTable extends Migration {

	public function up()
	{
		Schema::create('contracts', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('customer_id')->unsigned();
			$table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
			$table->integer('project_id')->unsigned()->nullable();
			$table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
			$table->string('sow_number', 150);
			$table->string('amendment_number', 150)->nullable();
			$table->date('date');
			$table->date('start_date');
			$table->date('finish_date');
			$table->integer('engagement_id')->unsigned();
			$table->foreign('engagement_id')->references('id')->on('engagements')->onDelete('cascade');
			$table->text('service_description');
			$table->string('workinghours_from')->nullable();
			$table->string('workinghours_to')->nullable();

            $table->integer('currency_id')->unsigned();
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
		});
	}

	public function down()
	{

        Schema::table('currencies', function(Blueprint $table) {
            $table->dropForeign('contracts_currency_id_foreign');
        });

		Schema::table('contracts', function(Blueprint $table) {
			$table->dropForeign('contracts_project_id_foreign');
		});

		Schema::table('contracts', function(Blueprint $table) {
			$table->dropForeign('contracts_engagement_id_foreign');
		});

		Schema::table('contracts', function(Blueprint $table) {
			$table->dropForeign('contracts_customer_id_foreign');
		});
		Schema::drop('contracts');
	}
}