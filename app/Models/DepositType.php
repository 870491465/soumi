<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepositType extends BaseModel
{
    //
    const PULL_USE = 1;
    const SELL = 2;

    protected  $table = 'deposit_types';
    protected $fillable = ['id', 'name'];
}
