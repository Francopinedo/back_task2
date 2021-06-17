<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceService extends Model {

	protected $table = 'invoice_services';
	public $timestamps = true;
	protected $fillable = array('cost','amount', 'currency_id', 'invoice_id', 'detail', 'file');

	public function Currency()
	{
		return $this->belongsTo('App\Currency');
	}

	public function Invoice()
	{
		return $this->belongsTo('App\Models\Invoice');
	}

}