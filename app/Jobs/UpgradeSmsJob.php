<?php

namespace App\Jobs;

use App\Models\Account;
use App\Models\Customer;
use App\Models\SmsContent;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class UpgradeSmsJob
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $model ;
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
        $account_id = $this->model->account_id;
        $account = Account::find($account_id);
        $account_name = $account->person_name;
        $role_id = $account->role_id;
        $primary = Customer::where('child_id', $account_id)->first();
        if ($primary) {  //存在 找出收益金额
            $primary_role = $primary->primaryAccount->user->role_id;   //找出上一级代理级别
            $primary_name = $primary->primaryAccount->person_name;
            $agent_role = $role_id;    //本级别
            if ($agent_role > $primary_role) { //如果升级的级别大于上一级
                $content = SmsContent::first(1)->content;
                $content = str_replace('#name#', $primary_name, $content);
                $sms_content = str_replace('#upgrade_name#', $account_name, $content);

                $ch = curl_init();// 必要参数
                $apikey = "4e167823fb200d47f8faba8d0831604d"; //修改为您的apikey(https://www.yunpian.com)登录官网后获取
                $mobile = $primary->primaryAccount->user->mobile; //请用手机号代替
                $data=array('text'=>$sms_content, 'apikey'=>$apikey,'mobile'=>$mobile);
                curl_setopt ($ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/sms/single_send.json');
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
                $json_data = curl_exec($ch);
                Log::info($json_data);
            }
        }
    }
}
