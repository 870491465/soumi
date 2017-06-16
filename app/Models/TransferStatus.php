<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransferStatus extends BaseModel
{
    const PENDING = 1;
    const FAILD = 2;
    const SUCCESS = 3;
    const CANCEL = 4;
    //
    protected  $table = 'transfer_statuses';
    public $fillable = ['id', 'name'];

}
