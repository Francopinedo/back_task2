<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auditlog extends Model {

	protected $table = 'audit_log';
	public $timestamps = true;
	protected $fillable = array('date_action', 'process_name', 'action_name', 'user_id', 'user_comment', 'reason', 'business_rule', 'customer_id', 'project_id', 'role', 'action','table_name','field','user_name');

public function User()
	{
		return $this->belongsTo('App\Models\User');
	}
	
}
