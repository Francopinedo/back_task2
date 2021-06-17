<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToWikiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('wiki', function(Blueprint $table)
		{
			$table->foreign('customer_id')->references('id')->on('customers')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('project_id')->references('id')->on('projects')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('wiki', function(Blueprint $table)
		{
			$table->dropForeign('wiki_customer_id_foreign');
			$table->dropForeign('wiki_project_id_foreign');
			$table->dropForeign('wiki_user_id_foreign');
		});
	}

}
