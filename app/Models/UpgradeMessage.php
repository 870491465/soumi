<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UpgradeMessage extends Model
{
    //

    public  $table = 'upgrade_messages';
    public $fillable = ['name', 'mobile', 'content'];
}
