<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractMaterial extends Model {

	protected $table = 'contract_materials';
	public $timestamps = true;
	protected $fillable = array('cost', 'amount', 'currency_id', 'contract_id', 'detail', 'material_id', 'reimbursable','frequency');

	public function Contract()
	{
		return $this->belongsTo('App\Models\Contract');
	}

	public function Currency()
	{
		return $this->belongsTo('App\Currency');
	}

}