<?php

namespace App\Http\Controllers\Admin;

use App\Models\Account;
use App\Models\Balance;
use App\Models\ConvertAgentHistory;
use App\Models\Customer;
use App\Models\Deposit;
use App\Models\DepositStatus;
use App\Models\DepositType;
use App\Models\Role;
use App\Models\UpgradeHistory;
use App\Models\UpgradeType;
use App\Models\User;
use App\Models\ZhuanzhangHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    //
    public function index()
    {
        $accounts = Account::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.customer.index', ['accounts' => $accounts]);
    }

    public function store(Request $request)
    {
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
            'identity_card.min' => '身份证格式不正确',
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
        $password = substr($identity_card, -6);

        DB::beginTransaction();
        try {
            $account = new Account();
            $account->person_name = $person_name;
            $account->mobile = $mobile;
            $account->person_sex = $person_sex;
            $account->identity_card = $identity_card;
            $account->identity_card_pic = '';
            $account->business_name = '';
            $account->license_no = '';
            $account->license_pic = '';
            $account->save();

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
                'message' => '新增成功',
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

    public function search(Request $request)
    {
        $mobile = $request->get('mobile');
        $name = $request->get('name');
        $business_name = $request->get('business_name');

        $builder = Account::paginate(10000);
        if ($name) {

            $accounts = $builder->where('person_name', '=', $name);
        }
        if ($mobile) {
            $accounts = $builder->where('mobile', '=', $mobile);
        }
        if ($business_name) {
            $accounts = $builder->where('business_name', '=', $business_name);
        }
        return view('admin.customer.index', ['accounts' => $accounts]);
    }


    public function show($id)
    {
        $account = Account::find($id);
        if ($account) {
            return view('admin.authentication.detail', ['account' => $account]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => '资源不存在'
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $account_id = $id;
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
            'identity_car.min' => '身份证格式不正确'
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
            'redirectUrl' => ''
        ]);

    }

    public function setting($id)
    {
        $account = Account::find($id);

        return view('admin.customer.setting', ['account' => $account]);
    }

    public function upgrade($id)
    {
        $account = Account::find($id);
        $balance = Balance::where('account_id', $id)->first();
        return view('admin.customer.upgrade_role', ['account' => $account, 'balance' => $balance]);
    }

    public function postUpgrade(Request $request, $account_id)
    {
        $before_role = $request->get('before_role');
        $after_role = $request->get('after_role');
        $is_have_bonus = $request->get('is_have_bonus');
        if ($is_have_bonus) {

            $balance = Balance::where('account_id', $account_id)->first();
            if (!$balance) {
                return response()->json([
                    'status' => 'info',
                    'message' => '1.此用户余额不足, 无法升级'
                ]);
            }
            $is_have_bonus = 1;
            $amount = UpgradeType::where('role_id', $after_role)->first()->amount;
            $upgrade_supplort_amount = UpgradeType::find(1)->amount;
            $upgrade_operator_amount = UpgradeType::find(2)->amount;
            if ($before_role == 2 && $after_role == 3) {
                $amount = $upgrade_operator_amount-$upgrade_supplort_amount;

                if ($balance->amount < $amount) {
                    return response()->json([
                        'status' => 'info',
                        'message' => '2.此用户余额不足, 无法升级'
                    ]);
                }
            }
            if ($after_role == 2) {
                if ($balance->amount < $upgrade_supplort_amount) {
                    return response()->json([
                        'status' => 'info',
                        'message' => '3.此用户余额不足, 无法升级'
                    ]);
                }
            }

            $deposit = new Deposit();
            $deposit->account_id = $account_id;
            $deposit->amount = $amount;
            $deposit->upgrade_type_id = $after_role;
            $deposit->deposit_type_id = DepositType::PULL_USE;
            $deposit->status_id = DepositStatus::PENDING;
            $deposit->save();

            $balance->amount = $balance->amount - $amount;
            $balance->save();

        } else {
            $is_have_bonus = 0;
        }

        $user = User::where('account_id', $account_id)->first();
        $user->role_id = $after_role;
        $user->save();
        $upgrade_history = UpgradeHistory::create(['account_id' => $account_id, 'before_role' => $before_role,
            'after_role' => $after_role, 'is_have_bonus' => $is_have_bonus]);
        if ($upgrade_history) {
            return response()->json([
                'status' => 'success',
                'message' => '升级成功',
                'redirect' => '/admin/customer/upgrade'
            ]);
        }
    }

    public function convertAgent($id)
    {
        $account = Account::find($id);
        $customer = Customer::where('child_id', $id)->first();
        $accounts = Account::all();
        return view('admin.customer.convert_agnet', [
            'account' => $account,
            'customer' => $customer,
            'accounts' => $accounts]);
    }

    public function postConvert(Request $request)
    {
        $rules = ['primary_account' => 'required'];
        $messages = ['primary_account.required' => '请选择新代理'];
        $validate = Validator::make($request->all(), $rules, $messages);
        if ($validate->fails()) {
            return response()->json([
               'status' => 'error',
                'messages' => $validate->messages()->toArray()
            ]);
        }


        $account_id = $request->get('account_id');
        $primary_account = $request->get('primary_account');
        $before_agent = $request->get('before_agent');
        $customer = Customer::where('child_id', $account_id)->first();

        if ($customer) {
            $customer->account_id = $primary_account;
            $customer->save();
            $convert_agent_history = ConvertAgentHistory::create([
                'account_id' => $account_id,
                'before_agent' => $before_agent,
                'after_agent' => $primary_account
            ]);
        } else {
            $customer = new Customer();
            $customer->account_id = $primary_account;
            $customer->child_id = $account_id;
            $customer->save();
            $convert_agent_history = ConvertAgentHistory::create([
                'account_id' => $account_id,
                'before_agent' => $primary_account,
                'after_agent' => $primary_account
            ]);
        }
        return response()->json([
           'status' => 'success',
            'message' => '设置成功',
            'redirectUlr' => ''
        ]);
    }

    public function hedgeAmount($id)
    {
        $account = Account::find($id);
        $balance = Balance::where('account_id', $id)->first();
        $accounts = Account::all();

        return view('admin.customer.hedge_amount', [
            'account' => $account,
            'balance' => $balance,
            'accounts' => $accounts
        ]);
    }

    public function postHedgeAmount(Request $request, $id)
    {
        $rules = [
            'amount' => 'required',
            'collection_account' => 'required'
        ];

        $messages = [
            'amount.required' => '请输入金额',
            'collection_account.required' => '请选择对方账户'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
               'status' => 'error',
                'messages' => $validator->messages()->toArray()
            ]);
        }

        $amount = $request->get('amount');
        $collection_account = $request->get('collection_account');
        $zhuanzhang = ZhuanzhangHistory::create([
           'account_id' => $id,
            'amount' => $amount,
            'collection_account' => $collection_account
        ]);

        $balance = Balance::where('account_id', $collection_account)->first();
        if ($balance) {
            $balance->amount = $balance->amount + $amount;
            $balance->save();
        } else {
            $balance = new Balance();
            $balance->account_id = $collection_account;
            $balance->amount = $amount;
            $balance->save();
        }

        $balance = Balance::where('account_id', $id)->first();
        $balance->amount = $balance->amount- $amount;
        $balance->save();

        return response()->json([
            'status' => 'success',
            'message' => '转账成功'
        ]);
    }
}
