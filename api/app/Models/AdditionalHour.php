<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdditionalHour extends Model {

	protected $table = 'additional_hours';
	public $timestamps = true;
	protected $fillable = array('project_id', 'project_role_id', 'seniority_id', 'comments', 'date', 'hours', 'user_id', 'rate_id', 'rate', 'currency_id',
        'workplace', 'comments', 'contract_id', 'office_id', 'country_id', 'city_id');

	public function Project()
	{
		return $this->belongsTo('App\Models\Project');
	}

	public function User()
	{
		return $this->belongsTo('App\Models\User');
	}

}