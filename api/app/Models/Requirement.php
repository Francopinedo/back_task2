<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requirement extends Model {

	protected $table = 'requirements';
	public $timestamps = true;
	protected $fillable = array(
							'project_id',
							'description',
							'type',
							'request_date',
							'status_comment',
							'due_date',
							'owner_id',
							'priority',
							'business_value',
							'requester_name',
							'requester_email',
							'requester_type',
							'approval_date',
							'approver_name',
							'comment'
						);

}