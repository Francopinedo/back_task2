<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectService extends Model {

	protected $table = 'project_services';
	public $timestamps = true;
	protected $fillable = array('cost', 'amount', 'currency_id', 'project_id', 'detail', 'service_id', 'reimbursable','frequency');

	public function Currency()
	{
		return $this->belongsTo('App\Currency');
	}

	public function Project()
	{
		return $this->belongsTo('App\Models\Project');
	}

}