<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWikiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wiki', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('customer_id')->unsigned()->index('wiki_customer_id_foreign');
			$table->integer('project_id')->unsigned()->index('wiki_project_id_foreign');
			$table->integer('user_id')->unsigned()->index('wiki_user_id_foreign');
			$table->enum('process_group_code', array('Initiating','Planning','Executing','Monitoring y Control','Closing','Iniciando','Planificacion','Ejecutando','Monitoreo y Control','Cerrando'));
			$table->enum('knowledge_code', array('Integration Management','Scope Management','Time Management','Cost Management','Quality Management','Team Management','Communications Management','Risk Management','StakeHolder Management','Procurement Management','Manejo de Integracion','Gestion de Alcance','Gestion de Tiempo','Manejo de Costos','Gestion de Calidad','Gestion de Equipos','Gestion de Comunicaciones','Gestion de Riesgo','Gestion de Interesados','Direccion de Procuracion'));
			$table->enum('swot_code', array('Strenghts','Weaknesses','Opportunities','Threats','Fortalezas','Debilidades','Oportunidades','Amenaza'));
			$table->string('explanation', 700);
			$table->string('action_taken', 475);
			$table->string('additionals_comments', 700);
			$table->text('attached_file', 65535)->nullable();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('wiki');
	}

}
