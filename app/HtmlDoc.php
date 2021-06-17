<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HtmlDoc extends Model
{
    protected $fillable = ['name', 'lang', 'html'];
}
