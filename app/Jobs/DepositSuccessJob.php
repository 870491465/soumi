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
use App\Models\UpgradeHistory;
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

class DepositSuccessJob
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
        $amount = $this->deposit->amount;
        $times = 1000;
        if ($amount == 6 * $times) {
            $role_id = 2;
        }
        if ($amount == 36 * $times) {
            $role_id = 3;
        }
        if ($amount == 3 * $times) {
            $role_id = 3;
        }
        DB::beginTransaction();
        try
        {
            //更新申请通道状态
            /*$upgrade = Upgrade::where('account_id', $account_id)->where('type_id', $upgrade_type_id)->first();
            $upgrade->status = 2 ;
            $upgrade->save();*/


            //更新用户权限
            $user = User::where('account_id', $account_id)->first();

            $before_role = $user->role_id;
            $upgrade_history = UpgradeHistory::create([
                'account_id' => $account_id,
                'before_role' => $before_role,
                'after_role' => $role_id, 'is_have_bonus' => 0]);

            $user->role_id = $role_id;
            $user->save();

            $this->bonus($account_id, $role_id, $amount);
            //跟新Balance_Transaction 状态

            DB::commit();
        } catch(Exception $e) {
            DB::rollback();
        }
    }

    //计算权益
    public function bonus($account_id, $role_id, $amount, $i = 1)
    {
       // if ($i != 2) {
            //寻找上一级代理
            $primary = Customer::where('child_id', $account_id)->first();
            if ($primary) {  //存在 找出收益金额
                $primary_role = $primary->primaryAccount->user->role_id;   //找出上一级代理级别
                $agent_role = $role_id;    //本级别
                $bonus_setting = BonusSetting::where('primary_role', $primary_role)
                    ->where('agent_role', $agent_role)->where('level', $i)->first();

                Log::info('primary_role='. $primary_role. 'agent_role'. $agent_role . 'i='. $i
                    .'account_id='.$account_id. 'primary='. $primary->account_id);
                $bonus_amount = 0;
                if ($bonus_setting) {
                    //如果按比率计算
                    if ($bonus_setting->is_rate == 1) {
                        $bonus_amount = $amount * $bonus_setting->rate;
                    }
                    //如果按固定金额计算
                    if ($bonus_setting->is_fixed == 1) {
                        $bonus_amount = $bonus_amount + $bonus_setting->fixed;
                    }
                    $bonus = Bonus::create(
                        [
                            'account_id' => $primary->account_id,
                            'amount' => $bonus_amount,
                            'bonus_setting_id' => $bonus_setting->id,
                            'paid_amount' => $amount,
                            'agent_account' => $account_id
                        ]
                    );
                }

            }

        //}
    }
}
