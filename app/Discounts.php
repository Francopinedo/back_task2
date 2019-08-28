<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discounts extends Model {

	protected $table = 'discounts';
	public $timestamps = true;
	protected $fillable = array('project_id', 'detail', 'voucher_number', 'voucher_image', 'amount', 'currency_id', 'period_from', 'period_to', 'from', 'to');

	public function Project()
	{
		return $this->belongsTo('App\Projects');
	}

	public function Currency()
	{
		return $this->belongsTo('App\Currency');
	}

}