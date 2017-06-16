<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BonusSetting extends BaseModel
{
    //
    protected $table = 'bonus_settings';

    public  $fillable = ['primary_role', 'agent_role', 'name', 'level',
        'deposit_type_id', 'is_rate', 'rate', 'is_fixed', 'fixed'];

    public function deposit_type()
    {
        return $this->hasOne(DepositType::class, 'id', 'deposit_type_id');
    }


}
