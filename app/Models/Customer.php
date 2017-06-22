<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends BaseModel
{
    //

    public function account()
    {
        return $this->hasOne(Account::class, 'id', 'child_id');
    }


    public function primaryAccount()
    {
        return $this->hasOne(Account::class, 'id', 'account_id');
    }


}
