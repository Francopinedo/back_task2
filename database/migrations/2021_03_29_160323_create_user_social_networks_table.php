<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserSocialNetworksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_social_networks', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->string('social_network', 100);
			$table->string('info', 150);
			$table->integer('user_id')->unsigned()->index('user_social_networks_user_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_social_networks');
	}

}
