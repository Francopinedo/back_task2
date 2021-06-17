<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = ['metadocument_id','version'];

    public function metadocument()
    {
        return $this->belongsTo('App\Metadocument');
    }

    public function variables()
	{
		return $this->hasMany('App\Variable');
    }
}
