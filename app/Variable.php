<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Variable extends Model
{
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];
    protected $fillable = ['document_id','metavariable_id','value'];

    public function document()
    {
        return $this->belongsTo('App\Document');
    }

    public function metavariable()
    {
        return $this->belongsTo('App\Metavariable');
    }
}
