<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkingHour extends Model {

	protected $table = 'working_hours';
	public $timestamps = true;
	protected $fillable = array('project_id','sprint_id', 'date', 'hours', 'user_id');

	public function Project()
	{
		return $this->belongsTo('App\Models\Project');
	}
	public function Sprint()
	{
		return $this->belongsTo('App\Models\Sprints');
	}


	public function User()
	{
		return $this->belongsTo('App\Models\User');
	}

}
