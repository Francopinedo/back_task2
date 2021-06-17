<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsenceTypeTemplate extends Model {

	protected $table = 'absence_types_template';
	public $timestamps = true;
	protected $fillable = array('country_id', 'city_id', 'title', 'days');

	public function Country()
	{
		return $this->belongsTo('App\Country');
	}

}