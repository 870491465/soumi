<?php

namespace App\Jobs;

use App\Models\BalanceTransaction;
use App\Models\BalanceTransactionStatus;
use App\Models\BalanceTransactionType;
use App\Models\Bonus;
use App\Models\BonusSetting;
use App\Models\Customer;
use App\Models\Role;
use App\Models\Upgrade;
use App\Models\UpgradeType;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use League\Flysystem\Exception;

class DepositSuccessJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $deposit;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($deposit)
    {
        $this->deposit = $deposit;
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $account_id = $this->deposit->account_id;
        $upgrade_type_id = $this->deposit->upgrade_type_id;
        $balance_transaction_id = $this->deposit->balance_transaction_id;

        DB::beginTransaction();
        try
        {
            //更新申请通道状态
            /*$upgrade = Upgrade::where('account_id', $account_id)->where('type_id', $upgrade_type_id)->first();
            $upgrade->status = 2 ;
            $upgrade->save();*/

            //更新用户权限
            $user = User::where('account_id', $account_id)->first();
            $user->role_id = $role_id;
            $user->save();

            //跟新Balance_Transaction 状态
            $balance_transaction = BalanceTransaction::find($balance_transaction_id);
            $balance_transaction->status_id = BalanceTransactionStatus::SUCCESS;
            $balance_transaction->save();
            DB::commit();
        } catch(Exception $e) {
            DB::rollback();
        }
    }
}
