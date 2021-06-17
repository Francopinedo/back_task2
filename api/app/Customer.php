<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model {

	protected $table = 'customers';
	public $timestamps = true;
	protected $fillable = array('company_id', 'name', 'address', 'city_id', 'email', 'phone', 'billing_name',
        'billing_address', 'tax_number1',
		'bank_name', 'account_number', 'swiftcode', 'aba', 'currency_id', 'industry_id','logo_path');

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
	public function Currency()
	{
		return $this->belongsTo('App\Currency');
	}

	public function Projects()
	{
		return $this->hasMany('App\Models\Project');
	}

}