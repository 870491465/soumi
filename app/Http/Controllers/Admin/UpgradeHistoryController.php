<?php

namespace App\Http\Controllers\Admin;

use App\Models\UpgradeHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpgradeHistoryController extends Controller
{
    //

    public function index()
    {
        $upgrade_historys = UpgradeHistory::orderBy('created_at', 'desc')->paginate(15);

        return view('admin.upgrade_history.index', ['upgrade_historys' => $upgrade_historys]);
    }

    public function store(Request $request, $account_id)
    {
        $before_role = $request->get('before_role');
        $after_role = $request->get('after_role');
        $is_have_bonus = $request->get('is_have_bonus');
        if ($is_have_bonus) {
            $is_have_bonus = 1;
        } else {
            $is_have_bonus = 0;
        }
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
}
