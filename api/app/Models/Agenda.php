<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model {

	protected $table = 'agenda';
	public $timestamps = true;
protected $fillable = array('company_id', 'project_id', 'knowledge_area', 'item_number', 'description', 'start', 'status', 'due', 'creator_id', 'owner_id', 'detail','priority');

	public function Company()
	{
		return $this->belongsTo('App\Models\Company');
	}

	public function Project()
	{
		return $this->belongsTo('App\Models\Project');
	}

	public function Creator()
	{
		return $this->belongsTo('App\Models\Users', 'creator_id');
	}

	public function Owner()
	{
		return $this->belongsTo('App\Models\Users', 'owner_id');
	}

}