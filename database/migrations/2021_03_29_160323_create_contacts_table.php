<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contacts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('company_id')->unsigned()->index('contacts_company_id_foreign');
			$table->integer('project_id')->unsigned()->nullable()->index('contacts_project_id_foreign');
			$table->string('name', 100);
			$table->string('company', 100);
			$table->string('department', 100);
			$table->integer('country_id')->unsigned()->index('contacts_country_id_foreign');
			$table->integer('city_id')->unsigned()->nullable()->index('contacts_city_id_foreign');
			$table->integer('industry_id')->unsigned()->index('contacts_industry_id_foreign');
			$table->string('email', 100);
			$table->string('phone', 20);
			$table->text('comments', 65535)->nullable();
			$table->integer('user_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contacts');
	}

}
