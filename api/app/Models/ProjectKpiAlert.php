<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectKpiAlert extends Model {

	protected $table = 'project_kpi_alerts';
	public $timestamps = true;
	protected $fillable = array('kpi_id', 'project_id', 'red_alert', 'yellow_alert', 'green_alert','percent_green_alert','percent_yellow_alert','percent_red_alert');

	public function Kpi()
	{
		return $this->belongsTo('App\Models\Kpi');
	}

	public function Project()
	{
		return $this->belongsTo('App\Models\Project');
	}

}