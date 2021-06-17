<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model {

	protected $table = 'dashboard';
	public $timestamps = true;
	protected $fillable = array('company_id', 'category', 'description', 'query','graphic_type','nombre','kpi','type_of_result','showdashboard');

	public function Company()
	{
		return $this->belongsTo('App\Models\Company');
	}

}
