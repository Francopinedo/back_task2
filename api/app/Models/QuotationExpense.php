<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationExpense extends Model {

	protected $table = 'quotation_expenses';
	public $timestamps = true;
	protected $fillable = array('cost', 'amount', 'currency_id', 'quotation_id', 'detail', 'file');

	public function Quotation()
	{
		return $this->belongsTo('App\Models\Quotation');
	}

	public function Currency()
	{
		return $this->belongsTo('App\Currency');
	}

}