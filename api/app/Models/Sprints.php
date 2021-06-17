<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sprints extends Model {

	protected $table = 'sprints';
	public $timestamps = true;
	protected $fillable = array(
							'customer_id',
							'project_id',
							'short_name',
							'long_name',
							'start_date',
							'finish_date',
							'Duration',
							'version',
							'release',
							'milestone',
							'NumberOfChangesRequired',
							'NumberOfChangesResolved',
							'time_status',
							'task_status',
							'active'
							
						);

	public function Project()
	{
		return $this->belongsTo('App\Project');
	}


	public function Customer()
	{
		return $this->belongsTo('App\Customer');
	}



}
