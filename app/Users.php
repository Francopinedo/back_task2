<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model {

	protected $table = 'users';
	public $timestamps = true;
	protected $fillable = array('name', 'email', 'password', 'address', 'office_phone', 'home_phone', 'cell_phone', 'city_id', 'company_id', 'company_role_id', 'project_role_id', 'seniority_id', 'office_id', 'workgroup_id');

	public function City()
	{
		return $this->belongsTo('App\Cities');
	}

	public function Company()
	{
		return $this->belongsTo('App\Companies');
	}

	public function Role()
	{
		return $this->belongsTo('App\Roles');
	}

	public function ProjectRole()
	{
		return $this->belongsTo('App\ProjectRoles');
	}

	public function Seniority()
	{
		return $this->belongsTo('App\Seniorities');
	}

	public function Office()
	{
		return $this->belongsTo('App\Offices');
	}

	public function Workgroup()
	{
		return $this->belongsTo('App\Workgroups');
	}

}