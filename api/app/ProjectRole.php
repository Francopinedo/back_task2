<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectRole extends Model {

	protected $table = 'project_roles';
	public $timestamps = true;
	protected $fillable = array('company_id', 'title');

	public function Company()
	{
		return $this->belongsTo('App\Company');
	}

}