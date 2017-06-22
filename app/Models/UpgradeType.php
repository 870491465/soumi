<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UpgradeType extends Model
{
    //
    protected $table = 'upgrade_types';
    public $fillable =  ['name', 'role_id', 'amount'];
}
