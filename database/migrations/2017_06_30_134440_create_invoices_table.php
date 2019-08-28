<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('project_id')->unsigned();
			$table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
			$table->string('number', 200);
			$table->string('purchase_order', 200);
			$table->string('concept', 200);
			$table->date('from');
			$table->date('to');
			$table->integer('contact_id')->unsigned();
			$table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
			$table->integer('currency_id')->unsigned();
			$table->foreign('currency_id')->references('id')->on('currencies')->onDelete('restrict');
			$table->date('due_date')->nullable();
			$table->float('total', 8,2);
			$table->string('bill_to', 200);
			$table->string('remit_to', 200);
			$table->boolean('emited');
			$table->text('comments');

		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function(Blueprint $table) {
            $table->dropForeign('invoices_contact_id_foreign');
        });

        Schema::table('invoices', function(Blueprint $table) {
            $table->dropForeign('invoices_currency_id_foreign');
        });

        Schema::table('invoices', function(Blueprint $table) {
            $table->dropForeign('invoices_project_id_foreign');
        });

        Schema::drop('invoices');
    }
}
