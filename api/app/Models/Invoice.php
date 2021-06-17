<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model {

	protected $table = 'invoices';
	public $timestamps = true;
	protected $fillable = array('project_id',
	'number',
	'purchase_order',
	'created_at',
	'concept',
	'from',
	'to',
	'contact_id',
	'currency_id',
	'due_date',
	'total',
	'bill_to',
	'remit_to',
	'currency_name',
	'emited',
	'comments',
        );

    public function Currency()
    {
        return $this->belongsTo('App\Currency');
    }
}
