<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model {

	protected $table = 'projects';
	public $timestamps = true;
	protected $fillable = array(
					'name',
					'customer_id',
					'contract_id',
					'customer_name',
					'start',
					'finish',
					'project_manager_id',
					'technical_director_id',
					'delivery_manager_id',
					'sow_number',
					'identificator',
					'status',
					'presales_responsable',
					'technical_estimator',
					'engagement',
					'estimated_revenue',
					'estimated_cost',
					'estimated_margin',
					'estimated_department_margin',
					'target_margin',
					'hours_by_day',
					'holy_days',
					'financial_deviation_threshold',
					'time_deviation_threshold',
					'department_id','name_convention');

	public function Customer()
	{
		return $this->belongsTo('App\Customer');
	}

	public function Department()
	{
		return $this->belongsTo('App\Department');
	}
    public function Chatroom()
    {
        return $this->belongsToMany('App\CompanyChatRoom','companychatroom_projects','project_id','companychatroom_id');
    }

}
