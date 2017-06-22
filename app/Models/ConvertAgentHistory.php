<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConvertAgentHistory extends Model
{
    //
    protected  $table = 'convertagent_historys';

    public $fillable = ['account_id', 'before_agent', 'after_agent'];
}
