<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DebitCredit extends Model {

	protected $table = 'debit_credit';
	public $timestamps = true;
	protected $fillable = array(
	'code',
	'company_id',
	'signs',
	'quantity',
	'detail',
	'amount',
	'currency_id',
	'cost_currency_id',
	'frequency',
		'cost',
        );

    public function Currency()
    {
        return $this->belongsTo('App\Currency');
    }
    public function Company()
	{
		return $this->belongsTo('App\Models\Company');
	}
  
}
