<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractService extends Model {

	protected $table = 'contract_services';
	public $timestamps = true;
	protected $fillable = array('cost', 'amount', 'currency_id', 'contract_id', 'detail', 'service_id', 'reimbursable','frequency');

	public function Currency()
	{
		return $this->belongsTo('App\Currency');
	}

	public function Contract()
	{
		return $this->belongsTo('App\Models\Contract');
	}

}