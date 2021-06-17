<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model {

	protected $table = 'services';
	public $timestamps = true;
	protected $fillable = array('company_id', 'reimbursable', 'detail', 'amount', 'currency_id', 'cost', 'cost_currency_id');

	public function Company()
	{
		return $this->belongsTo('App\Models\Company');
	}

	// public function Responsable()
	// {
	// 	return $this->belongsTo('App\Users', 'responsable');
	// }

	public function Currency()
	{
		return $this->belongsTo('App\Currency');
	}

	// public function Provider()
	// {
	// 	return $this->belongsTo('App\Provider');
	// }

}