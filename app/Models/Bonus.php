<?php

namespace App\Models;

class Bonus extends BaseModel
{
    //
    protected $table = 'bonus';

    protected $fillable = ['account_id', 'amount', 'bonus_setting_id', 'agent_account', 'paid_amount'];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function childAccount()
    {
        return $this->belongsTo(Account::class, 'agent_account');
    }

    public function type()
    {
        return $this->hasOne(BonusSetting::class, 'id', 'bonus_setting_id');
    }



}
