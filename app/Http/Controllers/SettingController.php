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
        return view('setting.index', ['account' => $account]);
    }
}
