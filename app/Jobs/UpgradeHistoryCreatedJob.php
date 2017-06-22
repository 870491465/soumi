<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpgradeHistoryCreatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $upgrade_history;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($upgrade_history)
    {
        //
        $this->upgrade_history = $upgrade_history;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $is_have_bonus = $this->upgrade_history->is_have_bonus;
        if ($is_have_bonus == 1) {
            $balance_transaction = new BalanceTransaction();
            $balance_transaction->account_id = $this->model->account_id;
            $balance_transaction->amount = $this->model->amount;
            $balance_transaction->balance_transaction_type_id = BalanceTransactionType::DEPOSIT;
            $balance_transaction->status_id = BalanceTransactionStatus::CREATED;
            $balance_transaction->save();
        }
    }
}
