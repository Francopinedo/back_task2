<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MetagridCell extends Model 
{
	use SoftDeletes;
    protected $table = 'metagrid_cells';
	protected $dates = ['deleted_at'];
	protected $fillable = ['metagrid_id','metavariable_kind_id','row','column','value','hyperlink_link','image_link'];

	public function metavariableKind()
	{
		return $this->belongsTo('App\MetavariableKind');
	}

	public function metagrid()
	{
		return $this->belongsTo('App\Metagrid');
	}

}