<?php

namespace App\Models;


use App\Events\TransferStatusUpdate;

class Transfer extends BaseModel
{
    //
    protected $table = 'transfers';

    public function status()
    {
        return $this->belongsTo(TransferStatus::class, 'status_id');
    }

    public function bankInfo()
    {
        return $this->belongsTo(AccountBank::class, 'account_bank_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    protected function fireCustomModelEvent($event, $method)
    {
        if ('updated' == $event &&
            $this->isDirty('status_id')) {
            event(new TransferStatusUpdate($this));
        }

        return parent::fireCustomModelEvent($event, $method);
    }
}
