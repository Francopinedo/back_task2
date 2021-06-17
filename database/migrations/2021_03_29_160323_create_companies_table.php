<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCompaniesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('companies', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 100);
			$table->string('address', 150)->nullable();
			$table->integer('city_id')->unsigned()->nullable()->index('companies_city_id_foreign');
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
			$table->integer('currency_id')->unsigned()->nullable()->index('companies_currency_id_foreign');
			$table->integer('industry_id')->unsigned()->nullable()->index('companies_industry_id_foreign');
			$table->integer('user_id')->unsigned()->index('companies_user_id_foreign');
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
		Schema::drop('companies');
	}

}
