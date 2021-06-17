<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmailCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('email_categories', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->string('title', 100);
			$table->integer('company_id')->unsigned()->index('email_categories_company_id_foreign');
			$table->string('added_by', 10)->nullable();
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
		Schema::drop('email_categories');
	}

}
