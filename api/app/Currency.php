<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model {

	protected $table = 'currencies';
	public $timestamps = true;
	protected $fillable = array('code', 'name');

    public function Invoices()
    {
        return $this->hasMany('App\Models\Invoice');
    }
}