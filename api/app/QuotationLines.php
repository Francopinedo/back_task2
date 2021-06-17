<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuotationLines extends Model {

	protected $table = 'quotation_lines';
	public $timestamps = true;
	protected $fillable = array('name', 'quotation_id', 'role', 'workplace', 'rate', 'phase', 'start', 'end', 'load', 'workinghours', 'comments');

	public function Quotation()
	{
		return $this->belongsTo('App\Quotation');
	}

}