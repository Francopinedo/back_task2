<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model {

	protected $table = 'materials';
	public $timestamps = true;
	protected $fillable = array('company_id', 'reimbursable', 'detail', 'amount', 'currency_id', 'cost', 'cost_currency_id');

	public function Company()
	{
		return $this->belongsTo('App\Models\Company');
	}

	public function Currency()
	{
		return $this->belongsTo('App\Currency');
	}

}