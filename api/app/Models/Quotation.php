<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model {

	protected $table = 'quotations';
	public $timestamps = true;
	protected $fillable = array('project_id', 'customer_id',
        'number',

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
        'comments');

	public function Project()
	{
		return $this->belongsTo('App\Models\Project');
	}

	public function Customer()
	{
		return $this->belongsTo('App\Customers');
	}
    public function Currency()
    {
        return $this->belongsTo('App\Currency');
    }
}