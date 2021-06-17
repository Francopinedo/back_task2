<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model {

	protected $table = 'rates';
	public $timestamps = true;
	protected $fillable = array('country_id', 'city_id', 'project_role_id', 'seniority_id', 'title', 'value', 'currency_id',
        'workplace', 'company_id','office_id');

	public function Country()
	{
		return $this->belongsTo('App\Country');
	}

	public function City()
	{
		return $this->belongsTo('App\City');
	}

	public function ProjectRole()
	{
		return $this->belongsTo('App\ProjectRole');
	}

	public function Currency()
	{
		return $this->belongsTo('App\Currency');
	}

	public function Company()
	{
		return $this->belongsTo('App\Models\Company');
	}

}