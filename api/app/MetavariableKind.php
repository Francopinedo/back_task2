<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MetavariableKind extends Model 
{
	use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'metavariable_kinds';
	protected $fillable = ['name_es','name_en'];

	public function metavariables()
	{
		return $this->hasMany('App\Metavariable');
    }

    public function metagridCells()
	{
		return $this->hasMany('App\MetagridCell');
    }

}