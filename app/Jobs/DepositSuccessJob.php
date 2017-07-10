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
        $upgrade_supplort_amount = UpgradeType::find(1)->amount;
        $upgrade_operator_amount = UpgradeType::find(2)->amount;
        if ($amount == $upgrade_supplort_amount) {
            $role_id = 2;
        }
        if ($amount == $upgrade_operator_amount) {
            $role_id = 3;
        }
        if ($amount == $upgrade_operator_amount-$upgrade_supplort_amount) {
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
                'after_role' => $role_id,
                'is_have_bonus' => 0]);

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
                if ($primary_role != 3 && $primary_role != 4) { //如果上级是不是运营商 也不是分公司，寻找上级是运营商，给运营商增加额外权益。
                    $this->serachOperator($primary->account_id, $amount, $account_id);
                }
                if ($primary_role != 4) { //如果上级不是分公司，寻找分公司，给分公司增加权益
                    $this->searchBranch($primary->account_id, $amount, $primary_role, $agent_role, $account_id);
                }

            }

        //}
    }

    /**
     * @param $account_id 上级代理
     * @param $amount
     * @param $primary_role
     * @param $agent_role
     * @param $fs_account 发生人
     * @return int
     */
    public function searchBranch($account_id, $amount, $pre_role, $agent_role, $fs_account)
    {
        Log::info('primary_account_id2='. $account_id);
        $primary_3 = Customer::where('child_id', $account_id)->first();

        if ($primary_3) { //存在上级
            $primary_role = $primary_3->primaryAccount->user->role_id;   //找出上一级代理级别
            Log::info('primary_account_role2='. $primary_role);
            if($primary_role != 4) { //判断上级是不是分公司，如果不是分公司，继续寻找上一级。
                $this->searchBranch($primary_3->account_id, $amount, $pre_role, $agent_role, $fs_account);
            } else
            {
                Log::info('primary->account_id2='. $primary_3->account_id);
                $bonus_setting = BonusSetting::where('primary_role', 4)
                    ->where('agent_role', $pre_role)->where('bottom_role', $agent_role)->where('level', 2)->first();
                $bonus_amount = 0;
                if ($bonus_setting->is_fixed == 1) {
                    $bonus_amount = $bonus_amount + $bonus_setting->fixed;
                }
                Bonus::create(
                    [
                        'account_id' => $primary_3->account_id,
                        'amount' => $bonus_amount,
                        'bonus_setting_id' => $bonus_setting->id,
                        'paid_amount' => $amount,
                        'agent_account' => $fs_account
                    ]
                );
            }
        } else { //不存在上级 直接退出
            return 0;
        }
    }

    public function serachOperator($account_id, $amount, $fs_account)
    {
        Log::info('primary_account_id='. $account_id);
        $primary_2 = Customer::where('child_id', $account_id)->first();
        if ($primary_2) { //存在上级
            $primary_role = $primary_2->primaryAccount->user->role_id;   //找出上一级代理级别
            Log::info('primary_account_role='. $primary_role);
            if($primary_role != 3) { //判断上级是不是运营商，如果不是运营商，继续寻找上一级。
                $this->serachOperator($primary_2->account_id, $amount, $fs_account);
            } else
            {
                Log::info('primary->account_id='. $primary_2->account_id);
                $bonus_setting = BonusSetting::where('primary_role', 3)
                    ->where('agent_role', 2)->where('level', 2)->first();
                $bonus_amount = 0;
                if ($bonus_setting->is_fixed == 1) {
                    $bonus_amount = $bonus_amount + $bonus_setting->fixed;
                }
                $bonus = Bonus::create(
                    [
                        'account_id' => $primary_2->account_id,
                        'amount' => $bonus_amount,
                        'bonus_setting_id' => $bonus_setting->id,
                        'paid_amount' => $amount,
                        'agent_account' => $fs_account
                    ]
                );
            }
        } else { //不存在上级 直接退出
            return 0;
        }
    }
}
