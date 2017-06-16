<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends BaseModel
{
    //
    const FREE = 1;
    const SUPPLIER = 2;
    const OPERATOR = 3;
    const BRANCH = 4;

    protected $fillable = ['id', 'name', 'display_name'];

    public $timestamps = false;


}
