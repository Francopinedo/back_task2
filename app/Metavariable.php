<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Metavariable extends Model 
{
        use SoftDeletes;

        protected $dates = ['deleted_at'];
        protected $fillable = ['id','metavariable_kind_id','name','caption','image_link','hyperlink_link','dependencies','metadocument_id','width'];

        public function metadocument()
        {
                return $this->belongsTo('App\Metadocument');
        }

        public function metavariableKind()
        {
                return $this->belongsTo('App\MetavariableKind');
        }
}