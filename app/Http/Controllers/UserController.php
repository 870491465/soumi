<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //

    public function getLogin()
    {

        return view('auth.login');
    }

    public function login(Request $request, $mobile)
    {
        $code = $request->get('code');
        $rules =  ['code' => 'required'];
        $messages = ['code.required' => '请输入手机号'];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'result_code' => 405,
                'message' => $validator->messages()->toArray()
            ]);
        }
        if (!isset($code)) {
            return response()->json([
                'result_code' => 405,
                'message' => 'code 不能为空'
            ]);
        }

        if (Auth::attempt(array('mobile' => $mobile, 'password' => $code), false)) {
            $user_id = Auth::user()->id;
            $user_name = Auth::user()->name;
            $user = User::find($user_id);
            $user_name = Auth::user()->name;
            $role = Auth::user()->role_id;
            $account_id = Auth::user()->account_id;
            $account = Account::find($account_id);
            if($account->status == 3)
            {
                return '此用户未审核通过';
            }
            // $role = $user->role();

            // $user_role = RoleUser::where('user_id', $user_id)->first()->load(['role']);
            //$role_name = $user_role->role->name;
            session()->put('role', $role);
            session()->put('username', $user_name);
            if($role == 0)
            {
                return '此用户正在审核中...';
            }
            if ($role == 2) {
                $display_name = '服务商';
                session()->put('color', 'teal');
            } elseif ($role == 3) {
                $display_name = '运营商';
                session()->put('color', 'blue');
            } elseif ($role == 5) {
                $display_name = '管理员';
            }

            session()->put('role_name', $display_name);
            $user->password = '';
            $user->code = '';
            $user->save();

          return  Redirect::to('/account/home');

        } else {
            return response()->json([
                'result_code' => 401,
                'message' => '验证错误'
            ]);
        }
    }

    public function postLogin(Request $request)
    {
        $rules =  ['mobile' => 'required'];
        $messages = ['mobile.required' => '请输入手机号'];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'messages' => $validator->messages()->toArray()
            ]);
        }

        $mobile = $request->get('mobile');
        $password = $request->get('password');
        if (Auth::attempt(array('mobile' => $mobile, 'password' => $password), false)) {
            $user_id = Auth::user()->id;
            $user_name = Auth::user()->name;
            $role = Auth::user()->role_id;

           // $role = $user->role();

           // $user_role = RoleUser::where('user_id', $user_id)->first()->load(['role']);
            //$role_name = $user_role->role->name;
            session()->put('role', $role);
            session()->put('username', $user_name);
            if ($role == 2) {
                $display_name = '服务商';
            } elseif ($role == 3) {
                $display_name = '运营商';
            } elseif ($role == 5) {
                $display_name = '管理员';
            }

            session()->put('role_name', $display_name);
            if($role == Role::ADMIN) {
                return response()->json([
                    'status' => 'success',
                    'redirectUrl' => '/admin/deposit'
                ]);
            } else {
                return response()->json([
                    'status' => 'success',
                    'redirectUrl' => '/account/home'
                ]);
            }
        } else {
            return response()->json([
                'status' => 'success',
                'message' => '密码或用户名错误'
            ]);
        }
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return Redirect::route('login');
    }

    public function getRegister()
    {
        return view('auth.register');
    }

    public function postRegister(Request $request)
    {
        $mobile = $request->get('mobile');
        $name = $request->get('name');
        $token = $request->get('_token');
        $password = $request->get('password');
        $rules = [
            'name' => 'required|max:20',
            'mobile' => 'regex:/^1[34578][0-9]{9}$/',
            'mobile' => 'required|unique:users',
            'password' => 'required|confirmed|between:6, 20',
        ];

        $messages = [
            'mobile.required' => '手机号不能为空',
            'mobile.regex' => '手机格式不正确',
            'email.unique' => '手机号已经存在',
            'password.confirmed' => '两次密码输入不一致',
            'password.between' => '密码长度为6-20位'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'messages' => $validator->messages()->toArray(),
            ]);
        }

        DB::beginTransaction();
        try {
            $num = $this->randNum();
            $account = Account::create(['mobile' => $mobile]);
            $user = new User();
            $user->name = $name;
            $user->mobile = $mobile;
            $user->password = Hash::make($password);
            $user->code = $num;
            $user->account_id = $account->id;
            $user->role_id = Role::FREE;
            $user->save();
            // Event::fire(new UserSignIn($user)); //用户注册 发送激活邮件
           // $user->notify((new UserSignUp($user)));

            DB::commit();
            return response()->json([
                'status' => 'success',
                'modalView' => view('auth.register_sms', ['mobile' => $mobile])->__toString(),
                'modal' => 'code_modal'
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

    public function validatorMobile($mobile, Request $request)
    {
        $code = $request->get('code');
        $user = User::where('mobile', $mobile)->where('code', $code)->first();
        if ($user) {
            $user->is_confirmed = 1;
            $user->code = '';
            $user->save();
            return response()->json([
                'status' => 'success',
                'message' => '注册成功',
                'redirectUrl' => '/login'
            ]);
        }
    }

    public function postChangePassword(Request $request)
    {

        $rules = [
            'oldpassword' => 'required|between:6, 20',
            'newpassword' => 'required|between:6, 20|confirmed',
        ];
        $messages = [
            'between' => '密码长度为6-20位',
            'confirmed' => '新密码两次输入不正确'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'messages' => $validator->messages()->toArray()
            ]);
        }

        $id = Auth::user()->id;
        $oldPassword = $request->get('oldpassword');
        $newPassowrd = $request->get('newpassword');
        $user = User::find($id);

        if (!Hash::check($oldPassword, $user->password)) {
            return response()->json([
                'status' => 'error', array('oldpassword' => '原始密码错误'),
            ]);
        }
        $user->password = Hash::make($newPassowrd);
        $user->save();
        return response()->json(['status' => 'success', 'message' => '密码修改成功']);
    }

    public function randNum()
    {
        $password = "";
        $chars = '0123456789';
        mt_srand((double)microtime() * 1000000 * getmypid());
        while (strlen($password) < 6)
            $password .= substr($chars, (mt_rand() % strlen($chars)), 1);
        return $password;
    }
}
