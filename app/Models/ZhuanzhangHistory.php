<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZhuanzhangHistory extends Model
{
    //
    protected $table = 'zhuanzhang_historys';

    protected $fillable = ['account_id', 'amount', 'collection_account'];

    public function account()
    {
        return $this->hasOne(Account::class, 'id', 'collection_account');
    }
}
