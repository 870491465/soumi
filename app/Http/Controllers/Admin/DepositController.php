<?php

namespace App\Http\Controllers\Admin;

use App\Models\Account;
use App\Models\Deposit;
use App\Models\UpgradeMessage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DepositController extends Controller
{
    //

    public function index()
    {
        $name = '李三';
        $mobile = '15905507737';
        $sfz = '340322198309210817';
        $sec_key = env('SECRET_KEY');
        $msg = implode('|', array($name, $sfz, $sec_key, $mobile));
        $new_sig = md5($msg);
        dd($new_sig);
        $deposits = Deposit::orderBy('created_at','desc')->orderBy('status_id', 'asc')->paginate(15);
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
        $upgrade_name = $request->get('upgradename');
        return view('admin.deposits.sendSms', [
           'mobile' => $mobile,
            'name' => $name,
            'upgrade_name' => $upgrade_name
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

    public function update(Request $request, $id)
    {
        $deposit = Deposit::find($id);
        $status = $request->get('status');
        $deposit->status_id = $status;
        $deposit->save();

        return response()->json([
           'status' => 'success',
            'message' => '审核成功',
            'redirectUrl' => ''
        ]);
    }

    public function search(Request $request)
    {
        $mobile = $request->get('mobile');
        $name = $request->get('name');
        $business_name = $request->get('business_name');

        if ($name) {
            $account_id = Account::where('name', '=', $name)->first()->id;
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
