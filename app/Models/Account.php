<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class Account extends BaseModel
{
    //
    protected $fillable = ['mobile', 'business_name', 'person_name', 'identity_card'];

    public function balance()
    {
        return $this->hasOne(Balance::class);
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    public function transfers()
    {
        return $this->hasMany(Transfer::class);
    }

    public function bonuses()
    {
        return $this->hasMany(Bonus::class);
    }

    public function upgrades()
    {
        return $this->hasMany(Upgrade::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function bank()
    {
        return $this->hasOne(AccountBank::class);
    }

    public function declarations()
    {
        return $this->hasMany(Declaration::class);
    }

    public function agent()
    {
        return $this->belongsTo(Customer::class, 'id', 'child_id');
    }

}
