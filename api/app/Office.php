<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Office extends Model {

	protected $table = 'offices';
	public $timestamps = true;
	protected $fillable = array('title', 'company_id', 'hours_by_day', 'city_id', 'workinghours_from', 'workinghours_to','effective_workinghours');

	public function Company()
	{
		return $this->belongsTo('App\Company');
	}

	public function departments()
	{
		return $this->hasMany('App\Department');
	}

}
