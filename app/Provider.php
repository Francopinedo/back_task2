<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model {

	protected $table = 'providers';
	public $timestamps = true;
	protected $fillable = array(
							'name',
							'address',
							'city_id',
							'email_1',
							'email_2',
							'email_3',
							'phone_1',
							'phone_2',
							'phone_3',
							'billing_name',
							'billing_address',
							'tax_number',
							'bank_name',
							'account_number',
							'swiftcode',
							'aba',
							'currency_id',
							'industry_id',
							'company_id','logo_path'
						);

	public function City()
	{
		return $this->belongsTo('App\City');
	}

	public function Currency()
	{
		return $this->belongsTo('App\Currency');
	}

	public function Industry()
	{
		return $this->belongsTo('App\Industry');
	}

}
