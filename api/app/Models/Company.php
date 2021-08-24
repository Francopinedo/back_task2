<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model {

	protected $table = 'companies';
	public $timestamps = true;
	protected $fillable = array(
		'name', 
		'address', 
		'country_id', 
		'city_id', 
		'email', 
		'phone', 
		'billing_name', 
		'billing_address', 
		'tax_number1',
		'bank_name', 
		'account_number', 
		'swiftcode', 
		'aba', 
		'currency_id', 
		'industry_id', 
		'user_id', 
		'logo_path');

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
    public function Domain()
    {
        return $this->hasOne('App\IredmailDomain');
    }
    public function RocketChatUsers()
    {
        return $this->hasMany('App\RocketChatUser','company_id','id');
    }

    public function Country()
    {
    	return $this->belongsTo('App\Country');
    }
}