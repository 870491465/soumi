<?php

namespace App\Models;

use App\Events\DeclarationStatusUpdate;
use Illuminate\Database\Eloquent\Model;

class Declaration extends Model
{

    protected $fillable = ['account_id', 'amount', 'invoice_pic', 'status_id'];
    //
    public function status()
    {
        return $this->belongsTo(DeclarationStatus::class, 'status_id');
    }

    protected function fireCustomModelEvent($event, $method)
    {
        if ('updated' == $event &&
            $this->isDirty('status_id')) {
            event(new DeclarationStatusUpdate($this));
        }
        return parent::fireCustomModelEvent($event, $method);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
