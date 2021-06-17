<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RocketChatUser extends Model
{
    protected $table = 'rocketchat_users';
    public $timestamps = true;
    protected $fillable = array('rcuser','rcpass','rcpath','user_id','company_id');

    public function user()
    {
      return $this->belongsTo('App\Models\User','user_id');
    }
    public function company()
    {
        return $this->belongsTo('App\Models\Company','company_id');
    }
}
