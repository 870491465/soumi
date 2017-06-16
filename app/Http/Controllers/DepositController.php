<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\DepositStatus;
use App\Models\DepositType;
use App\Models\Upgrade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepositController extends Controller
{
    //

    public function index()
    {
        $account_id = Auth::user()->account_id;
        $deposits = Deposit::where('account_id', $account_id)->get();
        return view('deposit.index' , ['deposits' => $deposits]);
    }

    public function store(Request $request)
    {
        $upgrade_id = $request->get('upgrade_id');
        $upgrade = Upgrade::find($upgrade_id);
        $account_id = Auth::user()->account_id;
        $amount = $upgrade->type->amount;

        $deposit = new Deposit();
        $deposit->account_id = $account_id;
        $deposit->amount = $amount;
        $deposit->status_id = DepositStatus::CREATE;
        $deposit->deposit_type_id = DepositType::PULL_USE;
        $deposit->deposit_id = md5(time() . mt_rand(3,1000000));
        $deposit->upgrade_type_id = $upgrade->type_id;
        $deposit->save();

        //充值页面
    }


}
