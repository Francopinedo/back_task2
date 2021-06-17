<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model {

	protected $table = 'discounts';
	public $timestamps = true;
	protected $fillable = array('company_id', 'detail', 'amount', 'currency_id','percentage');

	public function Company()
	{
		return $this->belongsTo('App\Models\Company');
	}

	public function Currency()
	{
		return $this->belongsTo('App\Currency');
	}

}