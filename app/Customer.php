<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model {

	protected $table = 'customers';
	public $timestamps = true;
	protected $fillable = array('company_id', 'name', 'address', 'city_id', 'industry_id', 'email', 'phone');

	public function Company()
	{
		return $this->belongsTo('App\Company');
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