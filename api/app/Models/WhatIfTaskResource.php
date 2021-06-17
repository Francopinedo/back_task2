<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatIfTaskResource extends Model
{

    protected $table = 'whatif_task_resources';
    public $timestamps = true;
    protected $fillable = array('whatif_task_id',
        'user_id',
        'project_role_id',
        'rate',
        'quantity', //en realidad se refiere al numero de horas
        'currency_id',
        'seniority_id');

    public function Currency()
	{
		return $this->belongsTo('App\Currency');
	}

	public function Seniority()
	{
		return $this->belongsTo('App\Currency');
	}
	public function WhatIfTask()
	{
		return $this->belongsTo('App\Models\WhatIfTask');
	}

}