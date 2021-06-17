<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationService extends Model {

	protected $table = 'quotation_services';
	public $timestamps = true;
	protected $fillable = array('cost','amount', 'currency_id', 'quotation_id', 'detail', 'file');

	public function Currency()
	{
		return $this->belongsTo('App\Currency');
	}

	public function Quotation()
	{
		return $this->belongsTo('App\Models\Quotation');
	}

}