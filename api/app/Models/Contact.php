<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model {

	protected $table = 'contacts';
	public $timestamps = true;
	protected $fillable = array('company_id', 'project_id', 'name', 'company', 'department', 'country_id', 'city_id', 'industry_id', 'email', 'phone', 'comments','user_id');

	public function Company()
	{
		return $this->belongsTo('App\Models\Company');
	}

	public function Project()
	{
		return $this->belongsTo('App\Models\Project');
	}

	public function Industry()
	{
		return $this->belongsTo('App\Industry');
	}

}
