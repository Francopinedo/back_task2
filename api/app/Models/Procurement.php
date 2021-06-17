<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Procurement extends Model {

	protected $table = 'procurements';
	public $timestamps = true;
	protected $fillable = array(
							'project_id',
							'type',
							'date',
							'description',
							'RFPID',
							'ContractID',
							'specifications',
							'approver_name',
							'responsable_id',
							'due_date',
							'cost',
							'cost_currency_id',
							'quality_required',
							'contract_status',
							'provider_id',
							'provider_feedback',
							'delivery',
							'quality',
							'overallscore',
							'requirement_status',
							'delivered_date'
						);

}