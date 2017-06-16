<?php

namespace App\Models;

use App\Events\DepositStatusUpdate;
use Illuminate\Database\Eloquent\Model;

class Deposit extends BaseModel
{
    //
    protected $table = 'deposits';

    public function type()
    {
        return $this->belongsTo(DepositType::class, 'deposit_type_id');
    }

    public function status()
    {
        return $this->belongsTo(DepositStatus::class, 'status_id');
    }

    public function upgrade_type()
    {
        return $this->belongsTo(UpgradeType::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    protected function fireCustomModelEvent($event, $method)
    {
        if ('updated' == $event &&
            $this->isDirty('status_id')) {
            event(new DepositStatusUpdate($this));
        }
        return parent::fireCustomModelEvent($event, $method);
    }
}
