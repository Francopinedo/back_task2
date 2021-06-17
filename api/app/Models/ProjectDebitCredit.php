<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectDebitCredit extends Model {

	protected $table = 'project_debit_credit';
	public $timestamps = true;
	protected $fillable = array(
	'project_id',
	'date',
	'code',
	'signs',
	'quantity',
	'detail',
	'amount',
	'currency_id',
	'due_date',
	'frequency',
		'cost',
        );

    public function Currency()
    {
        return $this->belongsTo('App\Currency');
    }
    public function Project()
    {
        return $this->belongsTo('App\Models\Project');
    }
}
