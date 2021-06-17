<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{

    use Authenticatable, Authorizable;

    protected $table = 'users';
    public $timestamps = true;
    protected $fillable = array('name', 'email', 'password', 'address', 'office_phone',
        'home_phone', 'cell_phone', 'city_id', 'company_role_id', 'project_role_id',
        'seniority_id', 'office_id', 'workgroup_id', 'profile_image_path', 'sidebar', 'theme', 'user_id','tooltip','timezone');

    protected $rules = [
        'email_address' => 'sometimes|required|email|unique:users'
    ];

    public function City()
    {
        return $this->belongsTo('App\City');
    }

    public function Role()
    {
        return $this->belongsTo('App\Role');
    }

    public function ProjectRole()
    {
        return $this->belongsTo('App\ProjectRole');
    }

    public function Seniority()
    {
        return $this->belongsTo('App\Seniority');
    }

    public function Office()
    {
        return $this->belongsTo('App\Office');
    }

    public function Workgroup()
    {
        return $this->belongsTo('App\Workgroup');
    }


    public function IredMailMail()
    {
        return $this->hasOne('App\IredmailMail','user_id','id');
    }
    public function RocketChatUser()
    {
        return $this->hasOne('App\RocketChatUser','user_id','id');
    }
    public function ChatRooms()
    {
        return $this->belongsToMany('App\CompanyChatRoom','companychatroom_users','user_id','companychatroom_id');
    }


}