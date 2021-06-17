<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KpiCategory extends Model {

	protected $table = 'kpis_category';
	public $timestamps = true;
	protected $fillable = array('name', 'company_id', 'roles');

	public function Company()
	{
		return $this->belongsTo('App\Models\Company');
	}

}