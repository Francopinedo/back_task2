<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_expenses', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('task_id')->unsigned();
			$table->foreign('task_id')->references('id')->on('tasks')->onDelete('restrict');
			$table->string('detail', 180);
			$table->double('cost', 18,2);
			$table->double('amount', 18,2);
			$table->boolean('reimbursable');
			$table->integer('quantity');
			$table->integer('currency_id')->unsigned();
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('restrict');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_expenses', function(Blueprint $table) {
            $table->dropForeign('task_expenses_task_id_foreign');
            $table->dropForeign('task_expenses_currency_id_foreign');
        });

        Schema::drop('task_expenses');
    }
}
