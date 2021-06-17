<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationMaterial extends Model {

	protected $table = 'quotation_materials';
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