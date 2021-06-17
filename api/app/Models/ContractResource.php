<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractResource extends Model {

	protected $table = 'contract_resources';
	public $timestamps = true;
	protected $fillable = array('project_role_id', 'seniority_id', 'qty', 'rate_id', 'rate', 'currency_id', 'load',
        'workplace', 'comments', 'contract_id', 'office_id', 'country_id', 'city_id');

	public function ProjectRole()
	{
		return $this->belongsTo('App\ProjectRole');
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

	public function Contract()
	{
		return $this->belongsTo('App\Contracts');
	}

}