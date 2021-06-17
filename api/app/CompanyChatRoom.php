<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyChatRoom extends Model
{
    protected $table = 'companychatroom';
    public $timestamps = true;
    protected $fillable = array('name','fullname','path','type');

    public function users()
    {
      return $this->belongsToMany('App\Models\User','companychatroom_users','companychatroom_id','user_id');
    }
}
