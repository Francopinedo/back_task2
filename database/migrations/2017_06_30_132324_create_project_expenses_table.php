<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_expenses', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('project_id')->unsigned();
			$table->foreign('project_id')->references('id')->on('projects');
			$table->string('detail', 150);
			$table->float('cost', 18, 2);
			$table->float('amount', 18, 2);
			$table->integer('currency_id')->unsigned();
			$table->foreign('currency_id')->references('id')->on('currencies');
			$table->integer('expense_id')->unsigned()->nullable();
			$table->foreign('expense_id')->references('id')->on('expenses');
			$table->boolean('reimbursable');
			$table->enum('frequency', array('monthly','weekly'));
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('project_expenses', function (Blueprint $table) {
            $table->dropForeign('project_expenses_project_id_foreign');
        });


        Schema::table('project_expenses', function (Blueprint $table) {
            $table->dropForeign('project_expenses_currency_id_foreign');
        });


        Schema::table('project_expenses', function (Blueprint $table) {
            $table->dropForeign('project_expenses_expense_id_foreign');
        });


        Schema::drop('project_expenses');
    }
}
