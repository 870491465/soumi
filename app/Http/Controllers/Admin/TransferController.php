<?php

namespace App\Http\Controllers\Admin;

use App\Models\Account;
use App\Models\Transfer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransferController extends Controller
{
    //

    public function index()
    {
        $transfers = Transfer::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.transfer.index', ['transfers' => $transfers]);
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
            $transfers = Transfer::where('account_id', $account_id)->orderBy('created_at', 'desc')->paginate(15);
        } else {
            $transfers = Transfer::orderBy('created_at', 'desc')->paginate(15);
        }

        return view('admin.transfer.index', ['transfers' => $transfers]);
    }
}
