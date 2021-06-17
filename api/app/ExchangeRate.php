<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model {

	protected $table = 'exchange_rates';
	public $timestamps = true;
	protected $fillable = array('currency_id', 'company_id', 'value','quotation_date','quotation_url');

	public function Currency()
	{
		return $this->belongsTo('App\Currency');
	}
}
