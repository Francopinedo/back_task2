<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Signature extends Model
{
    protected $table = 'signature';
    public $timestamps = true;
    
    protected $fillable = [
        'name',
        'signature',
        'created_at'
    ];
}
