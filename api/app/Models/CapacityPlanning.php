<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CapacityPlanning extends Model {

		protected $fillable = array('user_id','id','name', 'project_id','working_hours',  
			'absents_hours',
			'replacements_hours',
			'holidays_hours',
			'hours_available',
			'hours_asigned',
			'efective_capacity');

	
	public function Project()
	{
		return $this->belongsTo('App\Models\Project');
	}

	public function User()
	{
		return $this->belongsTo('App\Models\User');
	}

}