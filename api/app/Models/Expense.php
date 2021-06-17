<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model {

	protected $table = 'expenses';
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