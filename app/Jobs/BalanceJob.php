<?php

namespace App\Jobs;

use App\Models\Balance;
use App\Models\BalanceTransactionType;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class BalanceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $model;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($model)
    {
        $this->model = $model;
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $account_id = $this->model->account_id;
        $amount = $this->model->amount;
        Log::info('amount='. $amount);
        $balance = Balance::where('account_id', $account_id)->first();
        if (!$balance) {
            $balance = new Balance();
            $balance->account_id = $account_id;
            $balance->total = $amount;
            $balance->amount = $amount;
            $balance->save();
        }
        else
        {
            $old_total = $balance->total;
            $old_amount = $balance->amount;
            $balance->total = $old_total + $amount;
            $balance->amount = $old_amount + $amount;
            $balance->save();
        }
        //
    }

}
