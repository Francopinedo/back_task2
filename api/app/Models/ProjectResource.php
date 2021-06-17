<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectResource extends Model {

	protected $table = 'project_resources';
	public $timestamps = true;
	protected $fillable = array('project_role_id', 'seniority_id', 'user_id', 'rate_id', 'rate', 'currency_id', 'load', 'workplace', 'project_id', 'comments', 'office_id'
    , 'country_id', 'city_id', 'type');

	public function ProjectRole()
	{
		return $this->belongsTo('App\ProjectRole');
	}
	public function Company()
	{
		return $this->belongsTo('App\Models\Company');
	}

	public function Seniority()
	{
		return $this->belongsTo('App\Seniority');
	}

	public function Rate()
	{
		return $this->belongsTo('App\Models\Rate');
	}

	public function Currency()
	{
		return $this->belongsTo('App\Currency');
	}

	public function Project()
	{
		return $this->belongsTo('App\Models\Project');
	}

}