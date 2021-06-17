<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSocialNetworks extends Model {

	protected $table = 'user_social_networks';
	public $timestamps = true;
	protected $fillable = array('social_network', 'info', 'user_id');

	public function User()
	{
		return $this->belongsTo('App\Users');
	}

}