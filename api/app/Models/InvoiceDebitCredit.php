<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceDebitCredit extends Model {

	protected $table = 'invoice_debit_credit';
	public $timestamps = true;
	protected $fillable = array('cost', 'amount', 'currency_id', 'invoice_id', 'detail', 'signs');

	public function Invoice()
	{
		return $this->belongsTo('App\Models\Invoice');
	}

	public function Currency()
	{
		return $this->belongsTo('App\Currency');
	}

}