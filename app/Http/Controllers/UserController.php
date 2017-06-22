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
            $role = User::find($user_id)->role;
           // $role = $user->role();

           // $user_role = RoleUser::where('user_id', $user_id)->first()->load(['role']);
            //$role_name = $user_role->role->name;
            session()->put('role', $role->name);
            session()->put('username', $user_name);
            session()->put('role_name', $role->display_name);
            if($role == 'Admin') {
                return response()->json([
                    'status' => 'success',
                    'redirectUrl' => '/admin/home'
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