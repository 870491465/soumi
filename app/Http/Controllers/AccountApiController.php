<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Balance;
use App\Models\BalanceTransaction;
use App\Models\BalanceTransactionStatus;
use App\Models\Customer;
use App\Models\Deposit;
use App\Models\DepositStatus;
use App\Models\DepositType;
use App\Models\Hedge;
use App\Models\Role;
use App\Models\UpgradeHistory;
use App\Models\UpgradeType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use League\Flysystem\Exception;

class AccountApiController extends Controller
{
    //
    /**用户升级
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function promote(Request $request)
    {
        $rules = ['name' => 'required', 'mobile' => 'required',
            'identity_card_number' => 'required', 'api_sig' => 'required', 'amount' => 'required|numeric'];
        $messages = [
          'name.required' => '姓名不能为空',
          'mobile.required' => '手机号不能为空',
            'identity_card_number.required' => '身份证号不能为空',
            'api_sig.required' => '签名不能为空',
            'amount.required' => '金额不能为空',
            'amount.numeric' => '金额只能为数字'
        ];
        $validate = Validator::make($request->all(), $rules, $messages);
        if ($validate->fails()) {
            return response()->json([
                'result_code' => 405,
                'message' => $validate->messages()->toArray()
            ]);
        }
        $name = $request->get('name');
        $mobile = $request->get('mobile');
        $sfz = $request->get('identity_card_number');
        $amount = $request->get('amount');
        $api_sig = $request->get('api_sig');
        $agent_mobile = $request->get('api_sig');
        $secret_key = env('SECRET_KEY');
        $msg = implode('|', array($name, $sfz, $secret_key, $mobile));
        $new_sig = md5($msg);

        if ($new_sig == $api_sig) {

            if ($amount == 6000) {
                $role_id = Role::SUPPLIER; //服务商
            }
            if ($amount == 36000) {
                $role_id = Role::OPERATOR; //运营商
            }

            $account = Account::where('mobile', $mobile)->first();
            if (!$account) {
                if ($amount == 30000) {
                    return response()->json([
                        'result_code' => '400',
                        'message' => '金额有误，无法升级。请检查此商户是否已经为服务商!'
                    ]);
                }


                DB::beginTransaction();
                try {
                    $password = substr($sfz, 0, 3) . substr($sfz, -1, 3);
                    $account = Account::create([
                        'person_name' => $name,
                        'mobile' => $mobile,
                        'identity_card' => $sfz]);

                    $user = User::create([
                        'name' => $name,
                        'mobile' => $mobile,
                        'password' => Hash::make($password),
                        'account_id' => $account->id,
                        'role_id' => $role_id
                    ]);

                    if (isset($agent_mobile)) {
                        $agent_account = Account::where('mobile', $agent_mobile)->first();
                        if (isset($agent_account)) {
                            $customer = Customer::created(['account_id' => $agent_account->id, 'child_id' => $account->id]);
                        }
                    }

                    $deposit = new Deposit();
                    $deposit->account_id = $account->id;
                    $deposit->amount = $amount;
                    $deposit->upgrade_type_id = $role_id;
                    $deposit->deposit_type_id = DepositType::PULL_USE;
                    $deposit->status_id = DepositStatus::SUCCESS;
                    $deposit->save();

                    $upgrade_history = UpgradeHistory::create([
                        'account_id' => $account->id,
                        'before_role' => $role_id,
                        'after_role' => $role_id, 'is_have_bonus' => 0]);

                    DB::commit();
                    return response()->json([
                        'result_code' => '200',
                        'message' => '成功'
                    ]);

                } catch(Exception $e)
                {
                    DB::rollBack();
                }
            } else {
                if ($amount == 30000) {
                    $role_id = 3;
                    $user = User::where('mobile', $mobile)->first();
                    if ($user)
                    {
                        $before_role = $user->role_id;
                    } else {
                        return response()->json([
                            'result_code' => '400',
                            'message' => '金额有误，无法升级。请检查此商户是否已经为服务商!'
                        ]);
                    }
                }
                if ($amount == 3000) {
                    return response()->json([
                        'result_code' => '402',
                        'message' => '金额有误，无法升级。此用户已经是服务商!'
                    ]);
                }

                DB::beginTransaction();
                try
                {
                    $upgrade_history = UpgradeHistory::create([
                        'account_id' => $user->account_id,
                        'before_role' => $before_role,
                        'after_role' => $role_id, 'is_have_bonus' => 0]);

                    $user->role_id = $role_id;
                    $user->save();

                    $deposit = new Deposit();
                    $deposit->account_id = $user->account_id;
                    $deposit->amount = $amount;
                    $deposit->upgrade_type_id = $role_id;
                    $deposit->deposit_type_id = DepositType::PULL_USE;
                    $deposit->status_id = DepositStatus::SUCCESS;
                    $deposit->save();

                    DB::commit();
                    return response()->json(
                        [
                            'message' => 'success',
                            'result_code' => 200
                        ]
                    );
                } catch (Exception $e)
                {
                    DB::rollBack();
                    return response()->json(
                        [
                            'message' => $e->getMessage(),
                            'result_code' => 500
                        ]
                    );
                }

            }
        } else {
            return response()->json([
                'result_code' => 401,
                'message' => '签名错误'
            ]);
        }
    }

    public function api_sig($mobile)
    {
        $account = Account::where('mobile', $mobile)->first();
        $name = $account->person_name;
        $sfz = $account->identity_card;
        $secret_key = env('SECRET_KEY');
        $msg = implode('|', array($name, $sfz, $secret_key, $mobile));
        $new_sig = md5($msg);
        return $new_sig;
    }

    public function upgradeAmount(Request $request, $mobile)
    {
        if (!isset($mobile)) {
           return  response()->json([
                'result_code' => 405,
                'message' => '手机号不能为空'
            ]);
        }
        $rules = [
            'api_sig' => 'required'];
        $messages = [
            'api_sig.required' => '签名不能为空'
        ];
        $validate = Validator::make($request->all(), $rules, $messages);
        if ($validate->fails()) {
            return response()->json([
                'result_code' => 405,
                'message' => $validate->messages()->toArray()
            ]);
        }

        $account = Account::where('mobile', $mobile)->first();
        if (!$account) {
            $upgrade = UpgradeType::select('amount', 'role_id', 'name')->get();
            return response()->json([
                'result_code' => 200,
                'upgrade_type' => $upgrade->toArray()
            ]);
        } else {
            $api_sig = $request->get('api_sig');
            $new_sig = $this->api_sig($mobile);
            if ($new_sig == $api_sig) {
                $role_id = $account->user->role_id;
                if ($role_id == 2) {
                    return response()->json([
                        'result_code' => 200,
                        'upgrade_type' => array([
                            'role_id' => 3,
                            'name' => '运营商',
                            'amount' => 30000,
                        ],[
                            'role_id' => 2,
                            'name' => '服务商',
                            'amount' => 0,
                        ]
                            )
                    ]);
                } elseif($role_id == 3) {
                    return response()->json([
                        'result_code' => 200,
                        'upgrade_type' => array([
                            'role_id' => 3,
                            'name' => '运营商',
                            'amount' => 0,
                        ],[
                            'role_id' => 2,
                            'name' => '服务商',
                            'amount' => 0,
                        ]
                            )
                    ]);
                }
            } else {
                return response()->json([
                    'result_code' => 401,
                    'message' => '签名错误'
                ]);
            }
        }

      /*  if ($new_sig == $api_sig) {
            $account = Account::where('mobile', $mobile)->first();
            //如果存在
            if ($account) {
                $role_id = $account->user->role_id;
                if ($role_id == 2) {
                    return response()->json([
                        'result_code' => 200,
                        'upgrade_amount' => 30000,
                    ]);
                } else {
                    return response()->json([
                        'result_code' => 200,
                        'upgrade_amount' => 0,
                    ]);
                }
            } else {

            }
        } else {

        }*/
    }


    public function userLogin(Request $request, $mobile)
    {
        if (!isset($mobile)) {
            return  response()->json([
                'result_code' => 405,
                'message' => '手机号不能为空'
            ]);
        }
        $rules = [
            'api_sig' => 'required'];
        $messages = [
            'api_sig.required' => '签名不能为空'
        ];
        $validate = Validator::make($request->all(), $rules, $messages);
        if ($validate->fails()) {
            return response()->json([
                'result_code' => 405,
                'message' => $validate->messages()->toArray()
            ]);
        }

        $account = Account::where('mobile', $mobile)->first();
        $api_sig = $request->get('api_sig');
        if ($account) {
            $new_sig = $this->api_sig($mobile);
            if ($new_sig == $api_sig) {
                $user = User::where('mobile', $mobile)->first();
                $code = md5(rand(000000, 999999));
                $user->code = $code;
                $user->password = Hash::make($code);
                $user->save();
                return response()->json([
                    'result_code' => 200,
                    'return_url' => $_SERVER['SERVER_NAME'].'/login/'.$mobile.'?code='.$code
                ]);
            } else {
                return response()->json([
                    'result_code' => 401,
                    'message' => '签名错误'
                ]);
            }
        } else {
            return response()->json([
                'result_code' => 404,
                'message' => '资源不存在'
            ]);
        }
    }

    /**账户余额
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function accountBalance(Request $request, $mobile)
    {
        if (!isset($mobile)) {
            return  response()->json([
                'result_code' => 405,
                'message' => '手机号不能为空'
            ]);
        }

        $rules = [
            'api_sig' => 'required'];
        $messages = [
            'api_sig.required' => '签名不能为空'
        ];
        $validate = Validator::make($request->all(), $rules, $messages);
        if ($validate->fails()) {
            return response()->json([
                'result_code' => 405,
                'message' => $validate->messages()->toArray()
            ]);
        }
        $account = Account::where('mobile', $mobile)->first();
        $api_sig = $request->get('api_sig');
        if ($account) {
            $new_sig = $this->api_sig($mobile);
            if ($new_sig == $api_sig) {
                $balance = Balance::where('account_id', $account->id)->first();
                if ($balance) {
                    $balance_amount = $balance->amount;
                    return response()->json([
                        'result_code' => 200,
                        'message' => 'success',
                        'amount' => $balance_amount
                    ]);
                } else
                {
                    return response()->json([
                        'result_code' => 200,
                        'message' => 'success',
                        'amount' => 0.00
                    ]);
                }

            } else {
                return response()->json([
                    'result_code' => 401,
                    'message' => '签名错误'
                ]);
            }
        } else {
            return response()->json([
                'result_code' => 404,
                'message' => '资源不存在'
            ]);
        }

    }

    /**
     * 账户对冲
     */
    public function hedge(Request $request, $mobile)
    {
        if (!isset($mobile)) {
            return  response()->json([
                'result_code' => 405,
                'message' => '手机号不能为空'
            ]);
        }
        $rules = [
             'api_sig' => 'required',
            'amount' => 'required|numeric'];
        $messages = [
            'api_sig.required' => '签名不能为空',
            'amount.required' => '金额不能为空',
            'amount.numeric' => '金额只能为数字'
        ];
        $validate = Validator::make($request->all(), $rules, $messages);
        if ($validate->fails()) {
            return response()->json([
                'result_code' => 405,
                'message' => $validate->messages()->toArray()
            ]);
        }
        $api_sig = $request->get('api_sig');
        $amount = $request->get('amount');

        $account = Account::where('mobile', $mobile)->first();
        if ($account) {
            $new_sig = $this->api_sig($mobile);
            if ($new_sig == $api_sig) {
                $account = Account::where('mobile', $mobile)->first();
                if ($account) {
                    $hedge = Hedge::create(['account_id' => $account->id, 'amount' => -$amount, 'status' => 0]);
                    return response()->json([
                        'result_code' => 200,
                        'message' => 'success'
                    ]);
                }
            } else {
                return response()->json([
                    'result_code' => 401,
                    'message' => '签名错误'
                ]);
            }
        } else {
            return response()->json([
                'result_code' => 404,
                'message' => '资源不存在'
            ]);
        }
    }
}
