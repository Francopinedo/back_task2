<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatIfTask extends Model {

	protected $table = 'whatif_tasks';
	public $timestamps = true;
	protected $fillable = array(
		'whatif_id',
		'project_id',
		'description',
		'requirement_id',
		'start_date',
		'due_date',
		'start_is_milestone',
		'end_is_milestone',
		'progress',
		'depends',
		'priority',
		'estimated_hours',
		'burned_hours',
		'business_value',
		'phase',
		'version',
		'release',
		'label',
		'comments',
		'attachment',
		'level',
		'duration',
		'index',
		'status',
		'hours_by_day'
	);
public function WhatIf()
	{
		return $this->belongsTo('App\Models\WhatIf');
	}

}