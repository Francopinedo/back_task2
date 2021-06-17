<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Metagrid extends Model 
{
  use SoftDeletes;

  protected $dates = ['deleted_at'];
  protected $fillable = ['metadocument_id','name','caption'];

  public function metadocument()
  {
    return $this->belongsTo('App\Metadocument');
  }

  public function metagridCells()
  {
    return $this->hasMany('App\MetagridCell');
  }

}