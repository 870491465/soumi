<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeclarationStatus extends Model
{
    const PENDING = 1;
    const FAILD = 3;
    const SUCCESS =2;
    //
    public $fillable = ['id', 'name', 'display_name'];

    public $table = 'declaration_status';
    public $timestamps = false;
}
