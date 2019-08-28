<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskMaterialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_materials', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('task_id')->unsigned();
			$table->foreign('task_id')->references('id')->on('tasks')->onDelete('restrict');
			$table->string('detail', 180);
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('task_materials', function(Blueprint $table) {
            $table->dropForeign('task_materials_task_id_foreign');
        });

        Schema::drop('task_materials');
    }
}
