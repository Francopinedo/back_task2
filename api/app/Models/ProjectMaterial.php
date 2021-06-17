<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectMaterial extends Model {

	protected $table = 'project_materials';
	public $timestamps = true;
	protected $fillable = array('cost', 'amount','currency_id', 'project_id', 'detail', 'material_id', 'reimbursable','frequency');

	public function Project()
	{
		return $this->belongsTo('App\Models\Project');
	}

	public function Currency()
	{
		return $this->belongsTo('App\Currency');
	}

}