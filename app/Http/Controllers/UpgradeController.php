<?php

namespace App\Http\Controllers;

use App\Models\Upgrade;
use App\Models\UpgradeType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpgradeController extends Controller
{
    //

    public function index()
    {
        $account_id = Auth::user()->account_id;
        $role_id = Auth::user()->role_id;
        $upgrades = Upgrade::where('account_id', $account_id)->get();
        $upgrade_types = UpgradeType::where('role_id','>', $role_id)->get();

        return view('upgrade.index', ['upgrades' => $upgrades, 'upgrade_types' => $upgrade_types, 'i' => 1]);
    }

    public function store(Request $request)
    {
        $account_id = Auth::user()->account_id;
        $grade_type_id = $request->get('grade_type');
        $grade_type = UpgradeType::find($grade_type_id);
        $role_id = $grade_type->role_id;
        $upgrade = Upgrade::create(['account_id' => $account_id, 'role_id' => $role_id, 'type_id' => $grade_type_id, 'status' => 0]);

        return response()->json([
            'status' => 'success',
            'message' => '提交成功',
            'redirectUrl' => ''
        ]);

    }
}
