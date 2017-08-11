<?php

namespace App\Http\Controllers\Admin;

use App\Models\Account;
use App\Models\Balance;
use App\Models\Bonus;
use App\Models\BonusSetting;
use App\Models\Customer;
use App\Models\Deposit;
use App\Models\DepositStatus;
use App\Models\SmsContent;
use App\Models\UpgradeHistory;
use App\Models\UpgradeMessage;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DepositController extends Controller
{
    //

    public function index()
    {
        $name = '马琳圣';
        $mobile = '15205204742';
        $sfz = '370402199803174821';
        $sec_key = env('SECRET_KEY');
        $msg = implode('|', array($name, $sfz, $sec_key, $mobile));
        $new_sig = md5($msg);
        dd($new_sig);
        $deposits = Deposit::where('status_id', '<>', 5)->orderBy('created_at','desc')->orderBy('status_id', 'asc')->paginate(15);
        return view('admin.deposits.index', ['deposits' => $deposits]);
    }

    public function show($id)
    {
        $deposit = Deposit::find($id);
        return view('admin.deposits.update', ['id' => $id]);
    }

    public function sendUpgradeMessage(Request $request)
    {
        $mobile = $request->get('mobile');
        $name = $request->get('name');
        $sms_content = SmsContent::find(1)->content;
        $upgrade_name = $request->get('upgradename');
        $sms_content = str_replace('#name#', $name, $sms_content);
        $sms_content = str_replace('#upgrade_name#', $upgrade_name, $sms_content);
        return view('admin.deposits.sendSms', [
           'mobile' => $mobile,
            'name' => $name,
            'content' => $sms_content
        ]);
    }

    public function postSendUpgradeMessage(Request $request)
    {
        $mobile = $request->get('mobile');
        $name = $request->get('name');
        $content = $request->get('smscontent');
        UpgradeMessage::create([
           'mobile' => $mobile,
            'name' => $name,
            'content' => $content
        ]);

        $ch = curl_init();
// 必要参数
        $apikey = "4e167823fb200d47f8faba8d0831604d"; //修改为您的apikey(https://www.yunpian.com)登录官网后获取

        $text = $content;
// 发送短信
        $data=array('text'=>$text,'apikey'=>$apikey,'mobile'=>$mobile);
        curl_setopt ($ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/sms/single_send.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        $json_data = curl_exec($ch);
//解析返回结果（json格式字符串）
        $array = json_decode($json_data,true);

        return response()->json([
            'status' => 'success',
            'message' => '发送成功'
        ]);

    }

    public function delete(Request $request, $id)
    {
        $deposit = Deposit::find($id)->delete();
        $deposit->status_id = 5;
        $deposit->save();
        return response()->json([
            'status' => 'success',
            'message' => '删除成功',
            'redirectUrl' => ''
        ]);
    }

    public function update(Request $request, $id)
    {
        $deposit = Deposit::find($id);
        $status = $request->get('status');
        $deposit->status_id = $status;
        $deposit->save();

        if ($status == DepositStatus::FAILD) {
            $account_id = $deposit->account_id;
            $balance = Balance::where('account_id', $account_id)->first();

            if (!isset($balance)) {
                $balance = new Balance();
                $balance->account_id = $account_id;
                $balance->amount = $deposit->amount;
            } else {
                $balance->amount = $balance->amount+$deposit->amount;
            }

            $balance->save();
           // $this->handleDeposit($deposit);
        }

        return response()->json([
           'status' => 'success',
            'message' => '审核成功',
            'redirectUrl' => ''
        ]);
    }

    public function handleDeposit($model)
    {
        $account_id = $model->account_id;
        $amount = $model->amount;
        if ($amount == 6000) {
            $role_id = 2;
        }
        if ($amount == 36000) {
            $role_id = 3;
        }
        if ($amount == 30000) {
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
                        'agent_account' => $account_id
                    ]
                );
                $this->handleBalance($bonus);
            }

        }

        //}
    }

    public function handleBalance($model)
    {
        $account_id = $model->account_id;
        $amount = $model->amount;
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
    }


    public function search(Request $request)
    {
        $mobile = $request->get('mobile');
        $name = $request->get('name');
        $business_name = $request->get('business_name');

        if ($name) {
            $account_id = Account::where('person_name', '=', $name)->first()->id;
        }
        if ($mobile) {
            $account_id = Account::where('mobile', '=', $mobile)->first()->id;
        }
        if ($business_name) {
            $account_id = Account::where('business_name', '=', $business_name)->first()->id;
        }

        if ($account_id) {
            $deposits = Deposit::where('account_id',$account_id)->orderBy('created_at','desc')->paginate(15);
        } else
        {
            $deposits = Deposit::orderBy('created_at','desc')->paginate(15);
        }

        return view('admin.deposits.index', ['deposits' => $deposits]);
    }
}
