<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->tinyInteger('reimbursable');
			$table->string('detail', 100);
			$table->float('amount', 18,2);
			$table->float('cost', 18,2)->nullable();
			$table->integer('company_id')->unsigned();
			$table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
			$table->integer('cost_currency_id')->unsigned();
			$table->foreign('cost_currency_id')->references('id')->on('currencies')->onDelete('cascade');
			$table->integer('currency_id')->unsigned();
			$table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expenses', function(Blueprint $table) {
            $table->dropForeign('expenses_currency_id_foreign');
        });

        Schema::table('expenses', function(Blueprint $table) {
            $table->dropForeign('expenses_cost_currency_id_foreign');
        });

        Schema::table('expenses', function(Blueprint $table) {
            $table->dropForeign('expenses_company_id_foreign');
        });


        Schema::drop('expenses');
    }
}
