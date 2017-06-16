<?php

namespace App\Models;


class Upgrade extends BaseModel
{
    //
    protected $table = 'upgrade_applys';

    public $fillable = ['account_id', 'role_id', 'type_id', 'status'];
    public function type()
    {
        return $this->hasone(UpgradeType::class, 'id', 'type_id');
    }
}
