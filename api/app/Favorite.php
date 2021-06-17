<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model {

	protected $table = 'favorites';
	public $timestamps = true;
	protected $fillable = array('title', 'url', 'order', 'user_id');

	public function User()
	{
		return $this->belongsTo('App\User');
	}

}