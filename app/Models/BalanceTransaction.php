<?php

namespace App\Models;

use App\Events\BalanceTransactionStatusUpdate;
use Illuminate\Database\Eloquent\Model;

class BalanceTransaction extends BaseModel
{
    //
    protected $table = 'balance_transactions';

    public function type()
    {
        return $this->belongsTo(BalanceTransactionType::class, 'balance_transaction_type_id');
    }

    public function status()
    {
        return $this->belongsTo(BalanceTransactionStatus::class, 'status_id');
    }

    protected function fireCustomModelEvent($event, $method)
    {
        if ('updated' == $event &&
            $this->isDirty('status_id')) {
            event(new BalanceTransactionStatusUpdate($this));
        }
        return parent::fireCustomModelEvent($event, $method);
    }
}
