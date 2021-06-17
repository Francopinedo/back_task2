<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class TeamUser extends Model {

	protected $table = 'team_users';
	public $timestamps = true;
	protected $fillable = array('project_id', 'user_id','hours','load','date_from','date_to', 'office_id', 'country_id', 'city_id', 'workplace', 'project_role_id', 'seniority_id');

	public function Project()
	{
		return $this->belongsTo('App\Models\Project');
	}

	public function User()
	{
		return $this->belongsTo('App\Models\User');
	}

}