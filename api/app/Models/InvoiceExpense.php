<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceExpense extends Model {

	protected $table = 'invoice_expenses';
	public $timestamps = true;
	protected $fillable = array('cost', 'amount', 'currency_id', 'invoice_id', 'detail', 'file');

	public function Invoice()
	{
		return $this->belongsTo('App\Models\Invoice');
	}

	public function Currency()
	{
		return $this->belongsTo('App\Currency');
	}

}