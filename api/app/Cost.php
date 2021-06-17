<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cost extends Model {

	protected $table = 'costs';
	public $timestamps = true;
	protected $fillable = array('company_id', 'country_id', 'city_id', 'seniority_id', 'project_role_id', 'workplace', 'detail', 'value', 'currency_id');

	public function Company()
	{
		return $this->belongsTo('App\Company');
	}

	public function Country()
	{
		return $this->belongsTo('App\Country');
	}

	public function City()
	{
		return $this->belongsTo('App\City');
	}

	public function Seniority()
	{
		return $this->belongsTo('App\Seniority');
	}

	public function ProjectRole()
	{
		return $this->belongsTo('App\ProjectRole');
	}

	public function Currency()
	{
		return $this->belongsTo('App\Currency');
	}

}