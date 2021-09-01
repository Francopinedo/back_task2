<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model {

	protected $table = 'customers';
	public $timestamps = true;
	protected $fillable = array('company_id', 'name', 'address', 'country_id', 'city_id', 'industry_id', 'email', 'phone','logo_path');

	public function Company()
	{
		return $this->belongsTo('App\Company');
	}

	public function Country()
	{
		return $this->belongsTo('App\Country');
	}

	public function City()
	{
		return $this->belongsTo('App\City');
	}

	public function Industry()
	{
		return $this->belongsTo('App\Industry');
	}

}
