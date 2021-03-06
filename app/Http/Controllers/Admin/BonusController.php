<?php

namespace App\Http\Controllers\Admin;

use App\Models\Account;
use App\Models\Bonus;
use App\Models\BonusSetting;
use App\Models\DepositType;
use App\Models\Level;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BonusController extends Controller
{
    //
    public function index()
    {
        $bonus = Bonus::orderBy('created_at', 'desc')->paginate(15);

        return view('admin.bonus.index', ['bonus' => $bonus]);
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
            $bonus = Bonus::where('account_id', $account_id)->orderBy('created_at', 'desc')->paginate(15);
        } else {
            $bonus = Bonus::orderBy('created_at', 'desc')->paginate(15);
        }
        return view('admin.bonus.index', ['bonus' => $bonus]);
    }

    public function store(Request $request)
    {
        $rules = ['name' => 'required',
        'primary_role' => 'required',
            'agent_role' => 'required',
            'level' => 'required',
            'deposit_type_id' => 'required'
        ];
        $messages = [
          'name.required' => '请输入权益名称',
          'primary_role.required' => '请选择上级代理',
          'agnet_role.required' => '请选择代理级别',
          'deposit_type_id.required' => '请选择类型'
        ];
        $validate = Validator::make($request->all(), $rules, $messages);
        if ($validate->fails()) {
            return response()->json([
               'status' => 'error',
                'messages' => $validate->messages()->toArray()
            ]);
        }
        $is_fix = $request->get('is_fixed');
        $is_rate = $request->get('is_rate');
        $fix = $request->get('fixed');
        $rate = $request->get('rate');
        if (!isset($is_fix) && !isset($is_rate)) {
            return response()->json([
               'status' => 'error',
                'message' => ['is_fix' => '请选择一种计算方式']
            ]);
        }

        BonusSetting::create($request->all());
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
            'level' => 'required',
            'deposit_type_id' => 'required'
        ];
        $messages = [
            'name.required' => '请输入权益名称',
            'primary_role.required' => '请选择上级代理',
            'agnet_role.required' => '请选择代理级别',
            'deposit_type_id.required' => '请选择类型'
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
        $deposit_type_id = $request->get('deposit_type_id');
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
        $bonus->deposit_type_id = $deposit_type_id;
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
