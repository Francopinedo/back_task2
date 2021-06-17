<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model {

	protected $table = 'cities';
	public $timestamps = true;
	protected $fillable = array('name', 'location_name', 'country_id', 'company_id', 'timezone','added_by');

	public function country()
	{
		return $this->belongsTo('App\Country');
	}

}