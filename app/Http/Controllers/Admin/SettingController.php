<?php

namespace App\Http\Controllers\Admin;

use App\Models\UpgradeType;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    //
    public function index()
    {
        return view('admin.setting.index');
    }

    public function updatePassword()
    {
        return view('admin.setting.update_password');
    }

    public function updateSmsContent()
    {
        return view('admin.setting.smscontent');
    }

    public function depositAmount()
    {
        $upgrade_types = UpgradeType::get();
        return view('admin.setting.deposit_amount', ['upgrade_types' => $upgrade_types]);
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
}
