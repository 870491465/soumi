<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Bonus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BonusController extends Controller
{
    //

    public function index()
    {
        $account_id = Auth::user()->account_id;
        $bonus = Bonus::where('account_id',$account_id)->get();
        return view('bonus.index', ['bonuses' => $bonus, 'title' => '我的权益']);
    }
}
