<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('company_id')->unsigned()->index('customers_company_id_foreign');
			$table->string('name', 100);
			$table->string('address', 150)->nullable();
			$table->integer('country_id')->default(0);
			$table->integer('city_id')->unsigned()->nullable()->index('customers_city_id_foreign');
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
			$table->integer('currency_id')->unsigned()->nullable()->index('customers_currency_id_foreign');
			$table->integer('industry_id')->unsigned()->nullable()->index('customers_industry_id_foreign');
			$table->text('logo_path', 65535)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('customers');
	}

}
