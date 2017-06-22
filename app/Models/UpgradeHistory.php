<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UpgradeHistory extends Model
{
    //
    public $table = 'upgrade_historys';

    public $fillable = ['before_role', 'after_role', 'account_id', 'is_have_bonus'];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
