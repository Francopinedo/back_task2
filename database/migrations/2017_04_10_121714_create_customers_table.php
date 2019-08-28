<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomersTable extends Migration {

	public function up()
	{
		Schema::create('customers', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();

			$table->integer('company_id')->unsigned();
			$table->string('name', 100);
			$table->string('address', 150)->nullable();
			$table->integer('city_id')->unsigned()->nullable();
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('restrict');
			$table->string('email', 100)->nullable();
			$table->string('phone', 20)->nullable();
			$table->string('billing_name', 150)->nullable();
			$table->string('billing_address', 150)->nullable();
			$table->string('tax_number1', 150)->nullable();
			$table->string('tax_number2', 150)->nullable();
			$table->string('tax_number3', 150)->nullable();
			$table->string('bank_name', 100)->nullable();
			$table->string('account_number', 100)->nullable();
			$table->string('swiftcode', 100)->nullable();
			$table->string('aba', 100)->nullable();
			$table->integer('currency_id')->unsigned()->nullable();
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('restrict');
			$table->integer('industry_id')->unsigned()->nullable();

			$table->text('logo_path')->nullable();
		});
	}

	public function down()
	{

        Schema::table('customers', function(Blueprint $table) {
            $table->dropForeign('customers_currency_id_foreign');
        });

        Schema::table('customers', function(Blueprint $table) {
            $table->dropForeign('customers_city_id_foreign');
        });




		Schema::drop('customers');
	}
}