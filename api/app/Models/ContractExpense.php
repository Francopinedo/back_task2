<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractExpense extends Model {

	protected $table = 'contract_expenses';
	public $timestamps = true;
	protected $fillable = array('cost', 'amount', 'currency_id', 'contract_id', 'detail', 'expense_id', 'reimbursable', 'frequency');

	public function Contract()
	{
		return $this->belongsTo('App\Models\Contract');
	}

	public function Currency()
	{
		return $this->belongsTo('App\Currency');
	}

}