<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends BaseModel
{
    //
    protected $table = 'users';

    protected $fillable = ['name', 'mobile', 'password', 'role_id', 'account_id'];

    public function account()
    {
        return $this->hasOne(Account::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

}
