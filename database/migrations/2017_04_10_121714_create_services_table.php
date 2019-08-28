<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateServicesTable extends Migration {

	public function up()
	{
		Schema::create('services', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->tinyInteger('reimbursable');
			$table->string('detail', 100);
			$table->float('amount', 18,2);
			$table->float('cost', 18,2)->nullable();
			$table->integer('company_id')->unsigned();
			$table->integer('cost_currency_id')->unsigned();
			$table->integer('currency_id')->unsigned();

			$table->foreign('company_id')->references('id')->on('companies')
							->onDelete('cascade');

			$table->foreign('currency_id')->references('id')->on('currencies')
							->onDelete('cascade');

			$table->foreign('cost_currency_id')->references('id')->on('currencies')
							->onDelete('cascade');
		});
	}

	public function down()
	{
		Schema::drop('services');

		Schema::table('services', function(Blueprint $table) {
			$table->dropForeign('services_company_id_foreign');
		});
		Schema::table('services', function(Blueprint $table) {
			$table->dropForeign('services_currency_id_foreign');
		});
		Schema::table('services', function(Blueprint $table) {
			$table->dropForeign('services_cost_currency_id_foreign');
		});
	}
}