<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyChatRoom_Workgroups extends Model
{
    protected $table = 'companychatroom_workgroups';
    public $timestamps = true;
    protected $fillable = array('companychatroom_id','workgroup_id');
}
