<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCompanyRolesTable extends Migration {

	public function up()
	{
		Schema::create('company_roles', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('company_id')->unsigned();
			$table->string('title', 100);

		});
	}

	public function down()
	{
		Schema::drop('company_roles');
	}
}