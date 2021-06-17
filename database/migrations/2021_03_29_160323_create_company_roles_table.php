<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCompanyRolesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('company_roles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('company_id')->unsigned()->index('company_roles_company_id_foreign');
			$table->string('title', 100);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('company_roles');
	}

}
