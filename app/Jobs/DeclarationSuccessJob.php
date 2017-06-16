<?php

namespace App\Jobs;

use App\Models\BalanceTransaction;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DeclarationSuccessJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $declaratioin;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($declaration)
    {
        //
        $this->declaratioin = $declaration;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $account_id = $this->declaratioin->account_id;
        $balance_transaction_id = $this->declaratioin->balance_transaction_id;

        DB::beginTransaction();
        try
        {
            //跟新Balance_Transaction 状态
            $balance_transaction = BalanceTransaction::find($balance_transaction_id);
            $balance_transaction->status_id = BalanceTransactionStatus::SUCCESS;
            $balance_transaction->save();


        } catch(Exception $e) {
            DB::rollback();
        }
    }
}
