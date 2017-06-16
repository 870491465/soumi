<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepositStatus extends BaseModel
{
    //
    const CREATE = 1;
    const PENDING = 2;
    const SUCCESS = 3;
    const CANCEL = 4;
    const FAILD = 5;
    protected $table = 'deposit_statuses';

    protected $fillable = ['id', 'name'];

    public $timestamps = false;
}
