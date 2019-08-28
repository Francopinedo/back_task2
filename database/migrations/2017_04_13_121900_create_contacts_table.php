<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactsTable extends Migration {

	public function up()
	{
		Schema::create('contacts', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('company_id')->unsigned();
			$table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
			$table->integer('project_id')->unsigned()->nullable();
			$table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
			$table->string('name', 100);
			$table->string('company', 100);
			$table->string('department', 100);
			$table->integer('country_id')->unsigned();
			$table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
			$table->integer('city_id')->unsigned()->nullable();
			$table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
			$table->integer('industry_id')->unsigned();
			$table->foreign('industry_id')->references('id')->on('industries')->onDelete('cascade');
			$table->string('email', 100);
			$table->string('phone', 20);
			$table->text('comments')->nullable();
		});
	}

	public function down()
	{
		Schema::table('contacts', function(Blueprint $table) {
			$table->dropForeign('contacts_company_id_foreign');
		});

		Schema::table('contacts', function(Blueprint $table) {
			$table->dropForeign('contacts_project_id_foreign');
		});

		Schema::table('contacts', function(Blueprint $table) {
			$table->dropForeign('contacts_industry_id_foreign');
		});

		Schema::table('contacts', function(Blueprint $table) {
			$table->dropForeign('contacts_country_id_foreign');
		});

		Schema::table('contacts', function(Blueprint $table) {
			$table->dropForeign('contacts_city_id_foreign');
		});

		Schema::drop('project_contacts');
	}
}