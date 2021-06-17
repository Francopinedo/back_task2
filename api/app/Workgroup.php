<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workgroup extends Model {

	protected $table = 'workgroups';
	public $timestamps = true;
	protected $fillable = array('company_id', 'title');

	public function Company()
	{
		return $this->belongsTo('App\Company');
	}
	public function Chatroom()
    {
        return $this->belongsToMany('App\CompanyChatRoom','companychatroom_workgroups','workgroup_id','companychatroom_id');
    }

}