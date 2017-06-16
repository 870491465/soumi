<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends BaseModel
{
    //
    protected $table = 'users';

    public function account()
    {
        return $this->hasOne(Account::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

}
