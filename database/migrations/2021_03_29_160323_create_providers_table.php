<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProvidersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('providers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 100);
			$table->string('address', 150);
			$table->integer('country_id')->default(0);
			$table->integer('city_id')->unsigned()->index('providers_city_id_foreign');
			$table->string('email_1', 100);
			$table->string('email_2', 100);
			$table->string('email_3', 100);
			$table->string('phone_1', 20);
			$table->string('phone_2', 20);
			$table->string('phone_3', 20);
			$table->string('billing_name', 100);
			$table->string('billing_address', 150);
			$table->string('tax_number', 100);
			$table->string('bank_name', 100);
			$table->string('account_number', 100);
			$table->string('swiftcode', 100);
			$table->string('aba', 100);
			$table->integer('currency_id')->unsigned()->index('providers_currency_id_foreign');
			$table->integer('industry_id')->unsigned()->index('providers_industry_id_foreign');
			$table->integer('company_id')->unsigned()->index('providers_company_id_foreign');
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
		Schema::drop('providers');
	}

}
