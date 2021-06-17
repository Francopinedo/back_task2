<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CityTemplate extends Model {

	protected $table = 'cities_template';
	public $timestamps = true;
	protected $fillable = array('name', 'location_name', 'country_id', 'timezone');

	public function country()
	{
		return $this->belongsTo('App\Country');
	}

}