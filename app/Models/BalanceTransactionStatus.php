<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BalanceTransactionStatus extends BaseModel
{
    //
    const CREATED = 1;
    const PENDING = 2;
    const FAILD = 3;
    const SUCCESS = 4;
    const CANCEL = 5;

    protected $table = 'balance_transaction_statuses';

    protected $fillable = ['id', 'name'];

    public  $timestamps = false;
}
