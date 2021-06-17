<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DashboardCategory extends Model {

	protected $table = 'dashboard_category';
	public $timestamps = true;
	protected $fillable = array('name', 'company_id', 'roles');

	public function Company()
	{
		return $this->belongsTo('App\Models\Company');
	}

}