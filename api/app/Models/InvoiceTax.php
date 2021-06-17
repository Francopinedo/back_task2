<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceTax extends Model {

	protected $table = 'invoice_taxes';
	public $timestamps = true;
	protected $fillable = array('amount', 'currency_id', 'invoice_id', 'name', 'file', 'percentage');

	public function Invoice()
	{
		return $this->belongsTo('App\Models\Invoice');
	}

	public function Currency()
	{
		return $this->belongsTo('App\Currency');
	}

}