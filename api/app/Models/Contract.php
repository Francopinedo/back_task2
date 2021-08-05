<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model {

	protected $table = 'contracts';
	public $timestamps = true;
	protected $fillable = array(
		'customer_id',
		'project_id',
		'type_project',
		'sow_number',
		'amendment_number',
		'date', 'start_date', 'finish_date',
		'engagement_id',
		'currency_id',
		'service_description',
		'workinghours_from',
		'workinghours_to'
	);

	public function Project()
	{
		return $this->belongsTo('App\Models\Project');
	}

}