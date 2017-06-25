<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsContent extends Model
{
    //

    public $table = 'sms_contents';
    public $fillable = ['content'];
}
