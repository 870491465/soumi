<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Bank;
use App\Models\Customer;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    //

    public function index(Request $request)
    {
        $account_id = Auth::user()->account_id;
        $customers = Customer::where('account_id', $account_id)->get();
       // dd($customers);
        return view('customer.index', ['customers' => $customers]);
    }

    public function create()
    {
        return view('customer.create');
    }

    public function store(Request $request)
    {
        $account_id = Auth::user()->account_id;
        $rules = [
            'mobile' => 'required',
            'mobile' => 'regex:/^1[34578][0-9]{9}$/',
            'person_name' => 'required',
            'identity_card' => 'required|min:15',
        ];
        $messages = [
            'mobile.required' => '手机号不能为空',
            'mobile.regex' => '手机格式不正确',
            'person_name.required' => '姓名不能为空',
            'identity_card.required' => '身份证号不能为空',
            'identity_car.min' => '身份证格式不正确',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
               'status' => 'error',
                'messages' => $validator->messages()->toArray()
            ]);
        }
        $mobile = $request->get('mobile');
        $person_name = $request->get('person_name');
        $person_sex = $request->get('person_sex');
        $identity_card = $request->get('identity_card');
        $identity_card_pic = $request->get('identity_card_pic');
        $business_name = $request->get('business_name');
        $license_no  = $request->get('license_no');
        $license_pic = $request->get('license_pic');
        $password = substr($identity_card, -6);

        DB::beginTransaction();
        try {
            $account = new Account();
            $account->person_name = $person_name;
            $account->mobile = $mobile;
            $account->person_sex = $person_sex;
            $account->identity_card = $identity_card;
            $account->identity_card_pic = $identity_card_pic;
            $account->business_name = $business_name;
            $account->license_no = $license_no;
            $account->license_pic = $license_pic;
            $account->save();

            $customer = new Customer();
            $customer->account_id = $account_id;
            $customer->child_id = $account->id;
            $customer->save();

            $user = new User();
            $user->name = $person_name;
            $user->mobile = $mobile;
            $user->password = Hash::make($password);
            $user->account_id = $account->id;
            $user->role_id = Role::FREE;
            $user->save();
            // Event::fire(new UserSignIn($user)); //用户注册 发送激活邮件
            // $user->notify((new UserSignUp($user)));
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => '注册成功',
                'redirectUrl' => ''
            ]);
            // return view('auth.register_success', ['email_link' => $email_link, 'email' => $email]);
            //return response("<script>alert(trans('success.register_success'));window.location='/login'</script>");
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            return response()->json([
                'status' => 'info',
                'message' => '注册失败'
            ]);
            // Redirect::to('auth.register')->with('login_errors', trans('failure.login'));
        }
    }

    public function update(Request $request, $id)
    {
        $account_id = Auth::user()->account_id;
        $rules = [
            'mobile' => 'required',
            'mobile' => 'regex:/^1[34578][0-9]{9}$/',
            'person_name' => 'required',
            'identity_card' => 'required|min:15',
            'identity_card_pic' => 'required',
            'business_name' => 'required',
            'license_no' => 'required',
            'license_pic' => 'required'
        ];
        $messages = [
            'mobile.required' => '手机号不能为空',
            'mobile.regex' => '手机格式不正确',
            'person_name.required' => '姓名不能为空',
            'identity_card.required' => '身份证号不能为空',
            'identity_car.min' => '身份证格式不正确',
            'identity_card_pic.required' => '请上传身份证',
            'license_pic.required' => '请上传营业执照',
            'business_name.required' => '公司名称不能为空',
            'license_no.required' => '公司营业执照注册号不能为空',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'messages' => $validator->messages()->toArray()
            ]);
        }

        $mobile = $request->get('mobile');
        $person_name = $request->get('person_name');
        $person_sex = $request->get('person_sex');
        $identity_card = $request->get('identity_card');
        $identity_card_pic = $request->get('identity_card_pic');
        $business_name = $request->get('business_name');
        $license_no  = $request->get('license_no');
        $license_pic = $request->get('license_pic');

        $account = Account::find($account_id);
        $account->person_name = $person_name;
        $account->mobile = $mobile;
        $account->person_sex = $person_sex;
        $account->identity_card = $identity_card;
        $account->identity_card_pic = $identity_card_pic;
        $account->business_name = $business_name;
        $account->license_no = $license_no;
        $account->license_pic = $license_pic;
        $account->status = 1;
        $account->save();

        return response()->json([
            'status' => 'success',
            'message' => '提交成功',
        ]);

    }

    public function show($id)
    {
        $account_id  = Auth::user()->account_id;
        $customers = Customer::where('account_id', $account_id)->get();
        $child_account = Customer::where('child_id', $id)->where('account_id', $account_id)->first();
        if (!$child_account) {
            $account = Account::find($account_id);
        } else {
            $account = Account::find($id);
        }
        return view('customer.index', ['account' => $account, 'customers' => $customers]);
    }

    public function profile()
    {
        $account_id  = Auth::user()->account_id;
        $account = Account::find($account_id);
        $banks = Bank::all();
        return view('setting.profile', ['account' => $account, 'banks' => $banks]);
    }

}
