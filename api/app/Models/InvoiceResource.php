<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceResource extends Model {

	protected $table = 'invoice_resources';
	public $timestamps = true;
	protected $fillable = array('invoice_id', 'project_role_id', 'seniority_id', 'workplace', 'user_id', 'currency_id', 'load', 'rate', 'hours', 'type', 'comments',
        'rate_id','office_id', 'country_id', 'city_id');

	public function Currency()
	{
		return $this->belongsTo('App\Currency');
	}

	public function Invoice()
	{
		return $this->belongsTo('App\Models\Invoice');
	}
    public function User()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function ProjectRole()
    {
        return $this->belongsTo('App\ProjectRole');
    }

    public function Seniority()
    {
        return $this->belongsTo('App\Seniority');
    }
}