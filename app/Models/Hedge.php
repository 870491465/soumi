<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hedge extends Model
{
    //
    public $fillable = ['account_id', 'amount', 'status'];
}
