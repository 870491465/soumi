<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends BaseModel
{
    //
    public $timestamps = false;

    protected $fillable = ['name'];
}
