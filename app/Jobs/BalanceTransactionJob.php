<?php

namespace App\Jobs;

use App\Models\Balance;
use App\Models\BalanceTransaction;
use App\Models\BalanceTransactionStatus;
use App\Models\BalanceTransactionType;
use App\Models\Bonus;
use App\Models\Declaration;
use App\Models\DeclarationStatus;
use App\Models\Deposit;
use App\Models\Transfer;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use League\Flysystem\Exception;

class BalanceTransactionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $model;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($model)
    {
        //
        $this->model = $model;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $class_name = class_basename($this->model);
        Log::info('class_name='.$class_name);
        if ($class_name == 'Deposit') {
                DB::beginTransaction();
                try
                {
                    Log::info($this->model);
                    $balance_transaction = new BalanceTransaction();
                    $balance_transaction->account_id = $this->model->account_id;
                    $balance_transaction->amount = $this->model->amount;
                    $balance_transaction->balance_transaction_type_id = BalanceTransactionType::DEPOSIT;
                    $balance_transaction->status_id = BalanceTransactionStatus::CREATED;
                    $balance_transaction->save();

                    $deposit_id = $this->model->id;
                    $deposit = Deposit::find($deposit_id);
                    $deposit->balance_transaction_id = $balance_transaction->id;
                    $deposit->save();

                    DB::commit();
                } catch(Exception $e)
                {
                    DB::rollback();
                }

        }
        //商户权益
        if ($class_name == 'Bonus') {
            DB::beginTransaction();
            try
            {
                $balance_transaction = new BalanceTransaction();
                $balance_transaction->account_id = $this->model->account_id;
                $balance_transaction->amount = $this->model->amount;
                $balance_transaction->balance_transaction_type_id = BalanceTransactionType::BONUS;
                $balance_transaction->status_id = BalanceTransactionStatus::SUCCESS;
                $balance_transaction->save();

                $bonus = Bonus::find($this->model->id);
                $bonus->balance_transaction_id = $balance_transaction->id;
                $bonus->save();
                DB::commit();
            }catch(Exception $e) {
                DB::rollback();
            }
        }
        if ($class_name == 'Transfer') {
            DB::beginTransaction();
            try
            {
                $balance_transaction = new BalanceTransaction();
                $balance_transaction->account_id = $this->model->account_id;
                $balance_transaction->amount = $this->model->amount;
                $balance_transaction->balance_transaction_type_id = BalanceTransactionType::TRANSFER;
                $balance_transaction->status_id = BalanceTransactionStatus::CREATED;
                $balance_transaction->save();

                $transfer_id = $this->model->id;
                $transfer = Transfer::find($transfer_id);
                $transfer->balance_transacion_id = $balance_transaction->id;
                $transfer->save();

                $balance = Balance::where('account_id', $this->model->account_id)->first();
                if ($balance) {
                   $balance->amount = $balance->amount - $this->model->amount;
                    $balance->save();
                }
                DB::commit();

            } catch(Exception $e)
            {
                    DB::rollback();
            }
        }
        if ($class_name == 'Declaration') {
            DB::beginTransaction();
            try {
                $balance_transaction = new BalanceTransaction();
                $balance_transaction->account_id = $this->model->account_id;
                $balance_transaction->amount = $this->model->amount;
                $balance_transaction->balance_transaction_type_id = BalanceTransactionType::DECLARATION;
                $balance_transaction->status_id = BalanceTransactionStatus::PENDING;
                $balance_transaction->save();

                $declaration = Declaration::find($this->model->id);
                $declaration->balance_transaction_id = $balance_transaction->id;
                $declaration->save();
                DB::commit();
            } catch(Exception $e) {
                DB::rollback();
            }

        }
    }
}
