<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProvidersTable extends Migration {

	public function up()
	{
		Schema::create('providers', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 100);
			$table->string('address', 150);
			$table->integer('city_id')->unsigned();
			$table->foreign('city_id')->references('id')->on('cities')->onDelete('restrict');
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
			$table->integer('currency_id')->unsigned();
			$table->foreign('currency_id')->references('id')->on('currencies')->onDelete('restrict');
			$table->integer('industry_id')->unsigned();
			$table->foreign('industry_id')->references('id')->on('industries')->onDelete('restrict');
			$table->integer('company_id')->unsigned();
			$table->foreign('company_id')->references('id')->on('companies')->onDelete('restrict');
		});
	}

	public function down()
	{

        Schema::table('providers', function(Blueprint $table) {
            $table->dropForeign('providers_company_id_foreign');
        });

        Schema::table('providers', function(Blueprint $table) {
            $table->dropForeign('providers_industry_id_foreign');
        });


        Schema::table('providers', function(Blueprint $table) {
            $table->dropForeign('providers_currency_id_foreign');
        });

        Schema::table('providers', function(Blueprint $table) {
            $table->dropForeign('providers_city_id_foreign');
        });




		Schema::drop('providers');
	}
}