<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Bonus;
use App\Models\BonusSetting;
use App\Models\DepositType;
use App\Models\Level;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;

class BonusSettingController extends Controller
{
    //

    //
    public function index()
    {
        $roles = Role::where('name', '<>', 'Admin')->get();
        $bonus_seeting = BonusSetting::get();
        $levels = Level::get();
        $deposit_types = DepositType::all();
        return view('admin.bonussetting.index', [
            'bonus' => $bonus_seeting,
            'roles' => $roles,
            'deposit_types' => $deposit_types,
            'levels' => $levels
        ]);
    }
    public function store(Request $request)
    {
        $rules = ['name' => 'required',
            'primary_role' => 'required',
            'agent_role' => 'required',
            'level' => 'required'
        ];
        $messages = [
            'name.required' => '请输入权益名称',
            'primary_role.required' => '请选择上级代理',
            'agnet_role.required' => '请选择代理级别',
            'level.required' => '请选择级别'
        ];
        $validate = Validator::make($request->all(), $rules, $messages);
        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'messages' => $validate->messages()->toArray()
            ]);
        }
        $name = $request->get('name');
        $primary_role = $request->get('primary_role');
        $agent_role = $request->get('agent_role');
        $bottom_role = $request->get('bottom_role');
        $level = $request->get('level');
        $is_fix = $request->get('is_fixed');
        $is_rate = $request->get('is_rate');
        if ($is_rate)
        {
            $is_rate = 1;
        } else {
            $is_rate = 0;
        }
        if ($is_fix) {
            $is_fix = 1;
        } else {
            $is_fix = 0;
        }

        $fix = $request->get('fixed');
        if (!isset($fix)) {
            $fix = 0;
        }
        $rate = $request->get('rate');
        if (!isset($rate)) {
            $rate = 0;
        }
        if ($rate !=0) {
            $rate = $rate/100;
            $is_rate = 1;
        }
        if (!isset($is_fix) && !isset($is_rate)) {
            return response()->json([
                'status' => 'error',
                'message' => ['is_fix' => '请选择一种计算方式']
            ]);
        }
        $request['deposit_type_id'] =1;
        $bonus = new BonusSetting();
        $bonus->name = $name;
        $bonus->primary_role = $primary_role;
        $bonus->agent_role = $agent_role;
        $bonus->level = $level;
        $bonus->is_fixed = $is_fix;
        $bonus->is_rate = $is_rate;
        $bonus->bottom_role = $bottom_role;
        $bonus->rate = $rate;
        $bonus->deposit_type_id = 1;
        $bonus->fixed = $fix;
        $bonus->save();
        return response()->json([
            'status' => 'success',
            'message' => '添加成功',
            'redirectUrl' => ''
        ]);
    }

    public function edit(Request $request, $id)
    {
        $operate = $request->get('operate');
        if ($operate == 'del') {
            BonusSetting::find($id)->delete();
            return response()->json([
                'status' => 'success',
                'messages' => '删除成功',
                'redirectUrl' => ''
            ]);
        }

        $rules = ['name' => 'required',
            'primary_role' => 'required',
            'agent_role' => 'required',
            'level' => 'required'
        ];
        $messages = [
            'name.required' => '请输入权益名称',
            'primary_role.required' => '请选择上级代理',
            'agent_role.required' => '请选择代理级别',
        ];
        $validate = Validator::make($request->all(), $rules, $messages);
        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'messages' => $validate->messages()->toArray()
            ]);
        }

        $name = $request->get('name');
        $primary_role = $request->get('primary_role');
        $agent_role = $request->get('agent_role');
        $level = $request->get('level');
        $is_rate = 0;
        $is_fixed = 0;
        $rate = $request->get('rate');
        $fixed = $request->get('fixed');
        if ($rate !=0) {
            $rate = $rate/100;
            $is_rate = 1;
        }
        if ($fixed !=0) {
            $is_fixed = 1;
        }

        $bonus = BonusSetting::find($id);
        $bonus->name = $name;
        $bonus->primary_role = $primary_role;
        $bonus->agent_role = $agent_role;
        $bonus->level = $level;
        $bonus->is_fixed = $is_fixed;
        $bonus->is_rate = $is_rate;
        $bonus->rate = $rate;
        $bonus->fixed = $fixed;
        $bonus->save();

        return response()->json([
            'status' => 'success',
            'message' => '修改成功',
            'redirectUrl' => ''
        ]);

    }
}
