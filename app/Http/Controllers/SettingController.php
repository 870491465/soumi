<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    //
    public function index()
    {
        $account_id = Auth::user()->account_id;
        $account = Account::find($account_id);
        return view('setting.index', ['account' => $account, 'title' => '我的账户']);
    }

    public function bank()
    {
        $account_id = Auth::user()->account_id;
        $account = Account::find($account_id);
        return view('bank.index', ['account' => $account, 'title' => '银行账户']);
    }
}
