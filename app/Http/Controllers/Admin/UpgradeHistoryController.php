<?php

namespace App\Http\Controllers\Admin;

use App\Models\Deposit;
use App\Models\UpgradeHistory;
use Illuminate\Foundation\Auth\User;
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
                $amount = UpgradeType::find($after_role)->amount;
            if ($before_role == 2 && $after_role == 3) {
                $upgrade_supplort_amount = UpgradeType::find(1)->amount;
                $upgrade_operator_amount = UpgradeType::find(2)->amount;
                $amount = $upgrade_operator_amount-$upgrade_supplort_amount;
            }
            $deposit = new Deposit();
            $deposit->account_id = $account_id;
            $deposit->amount = $amount;
            $deposit->upgrade_type_id = $after_role;
            $deposit->deposit_type_id = DepositType::PULL_USE;
            $deposit->status_id = DepositStatus::PENDING;
            $deposit->save();
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
}
