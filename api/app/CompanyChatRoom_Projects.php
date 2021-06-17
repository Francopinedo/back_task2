<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyChatRoom_Projects extends Model
{
    protected $table = 'companychatroom_projects';
    public $timestamps = true;
    protected $fillable = array('companychatroom_id','project_id');
}
