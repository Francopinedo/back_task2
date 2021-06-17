<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsenceType extends Model {

	protected $table = 'absence_types';
	public $timestamps = true;
	protected $fillable = array('country_id', 'city_id', 'company_id', 'title', 'days');

	public function Country()
	{
		return $this->belongsTo('App\Country');
	}

}