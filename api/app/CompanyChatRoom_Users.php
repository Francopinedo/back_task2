<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyChatRoom_Users extends Model
{
    protected $table = 'companychatroom_users';
    public $timestamps = true;
    protected $fillable = array('companychatroom_id','user_id');
}
