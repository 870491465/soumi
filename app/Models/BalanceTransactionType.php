<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BalanceTransactionType extends BaseModel
{
    const DEPOSIT = 1;
    const TRANSFER = 2;
    const BONUS = 3;
    const DECLARATION =4;
    const HEGEG = 5;
    const UPGRADE =6;
    //
    protected $table = 'balance_transaction_types';

    protected $fillable = ['id', 'name'];
}
