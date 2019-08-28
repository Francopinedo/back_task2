<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdditionalHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('additional_hours', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('project_id')->unsigned();
			$table->foreign('project_id')->references('id')->on('projects')->onDelete('restrict');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->integer('rate_id')->unsigned()->nullable();
			$table->foreign('rate_id')->references('id')->on('rates')->onDelete('restrict');

            $table->integer('project_role_id')->unsigned();
            $table->foreign('project_role_id')->references('id')->on('project_roles')->onDelete('restrict');
            $table->integer('seniority_id')->unsigned();
            $table->foreign('seniority_id')->references('id')->on('seniorities')->onDelete('restrict');
            $table->float('rate', 18, 2);
            $table->integer('currency_id')->unsigned();
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('restrict');
            $table->tinyInteger('load');
            $table->enum('workplace', array('onsite', 'offshore'));
            $table->integer('office_id')->unsigned();
            $table->foreign('office_id')->references('id')->on('offices');
            $table->integer('country_id')->unsigned();
            $table->foreign('country_id')->references('id')->on('countries');
            $table->integer('city_id')->unsigned();
            $table->foreign('city_id')->references('id')->on('cities');


			$table->text('comments');
			$table->date('date');
			$table->tinyInteger('hours');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('additional_hours');
    }
}
