<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hobby extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'code', 'name'
    ];
}
