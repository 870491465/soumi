<?php

namespace App\Jobs;

use App\Models\Account;
use App\Models\Balance;
use App\Models\BalanceTransactionStatus;
use App\Models\BalanceTransactionType;
use App\Models\Bonus;
use App\Models\BonusSetting;
use App\Models\Customer;
use App\Models\Deposit;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class BalanceTransactionUpdateJob implements ShouldQueue
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
        $type = $this->model->balance_transaction_type_id;
        $status = $this->model->status_id;
        if ($status == BalanceTransactionStatus::SUCCESS) {
            if ($type == BalanceTransactionType::DEPOSIT) {
                $balance_transaction_id = $this->model->id;
                $deposit = Deposit::where('balance_transaction_id', $balance_transaction_id)->first();

                $account_id = $deposit->account_id;
                $role_id = $deposit->upgrade_type->role_id;
                $amount = $deposit->amount;
               // var_dump('account_id='. $account_id . 'role_id='. $role_id . 'amount=' .$amount);
                $this->bonus($account_id, $role_id, $amount);
            }
            if ($type == BalanceTransactionType::DECLARATION) {
                $balance_transaction_id = $this->model->id;
                $deposit = Deposit::where('balance_transaction_id', $balance_transaction_id)->first();

                $account_id = $deposit->account_id;
                $account = Account::find($account_id);
                $role_id = $account->role_id;
                $amount = $deposit->amount;
                // var_dump('account_id='. $account_id . 'role_id='. $role_id . 'amount=' .$amount);
                $this->declarationBonus($account_id, $role_id, $amount, 0);
            }
        }

        //
    }

    public function bonus($account_id, $role_id, $amount, $i = 1)
    {
        if ($i != 3) {
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
                            'agent_account' => $account_id
                        ]
                    );

                    $i++;
                    $this->bonus($primary->account_id, $role_id, $amount, $i);
                }

            }

        }
    }

    public function declarationBonus($account_id, $role_id, $amount, $i = 1)
    {
        if ($i != 2) {

            $primary = Customer::where('child_id', $account_id)->first();
            if ($primary) {
                $primary_role = $primary->account->user->role_id;
                $agent_role = $role_id;
                if ($i == 0) {
                    $bonus_setting = BonusSetting::where('primary_role', $primary_role)
                        ->where('agent_role', $agent_role)->where('level', $i)->first();
                } else {
                    $bonus_setting = BonusSetting::where('primary_role', $primary_role)
                    ->where('level', $i)->first();
                }

                $bonus_amount = 0;
                Log::info('primary_role='. $primary_role. 'agent_role'. $agent_role . 'i='. $i
                    .'account_id='.$account_id. 'primary='. $primary->account->id);
                if ($bonus_setting) {
                    //如果按比率计算
                    if ($bonus_setting->is_rate == 1) {
                        $bonus_amount = $amount * $bonus_setting->rate;
                    }
                    //如果按固定金额计算
                    if ($bonus_setting->is_fixed == 1) {
                        $bonus_amount = $bonus_amount + $bonus_setting->fixed;
                    }
                }
                if ($i == 0) {
                    $bonus_account = $account_id;
                } else
                {
                    $bonus_amount = $primary->account_id;
                }
                $bonus = Bonus::create(
                    [
                        'account_id' => $bonus_account,
                        'amount' => $bonus_amount,
                        'bonus_setting_id' => $bonus_setting->id,
                        'agent_account' => $account_id
                    ]
                );
                $i++;
                $this->bonus($primary->account_id, $role_id, $amount, $i);
            }
            else {
                $i = 2;
                $this->bonus('', '', 0, $i);
            }
        }
    }
}
