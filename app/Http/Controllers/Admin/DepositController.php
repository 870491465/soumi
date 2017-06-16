<?php

namespace App\Http\Controllers\Admin;

use App\Models\Account;
use App\Models\Deposit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DepositController extends Controller
{
    //

    public function index()
    {
        $deposits = Deposit::orderBy('created_at','desc')->paginate(15);
        $deposit = Deposit::find(15);
        return view('admin.deposits.index', ['deposits' => $deposits]);
    }

    public function search(Request $request)
    {
        $mobile = $request->get('mobile');
        $name = $request->get('name');
        $business_name = $request->get('business_name');

        if ($name) {
            $account_id = Account::where('name', '=', $name)->first()->id;
        }
        if ($mobile) {
            $account_id = Account::where('mobile', '=', $mobile)->first()->id;
        }
        if ($business_name) {
            $account_id = Account::where('business_name', '=', $business_name)->first()->id;
        }

        if ($account_id) {
            $deposits = Deposit::where('account_id',$account_id)->orderBy('created_at','desc')->paginate(15);
        } else
        {
            $deposits = Deposit::orderBy('created_at','desc')->paginate(15);
        }

        return view('admin.deposits.index', ['deposits' => $deposits]);
    }
}
