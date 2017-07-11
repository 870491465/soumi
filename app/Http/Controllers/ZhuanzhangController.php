<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Balance;
use App\Models\Customer;
use App\Models\ZhuanzhangHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ZhuanzhangController extends Controller
{
    //

    public function index()
    {
        $account_id = Auth::user()->account_id;
        $brings = ZhuanzhangHistory::where('account_id', $account_id)->orderBy('created_at', 'desc')->get();
        return view('bring.index', ['brings' => $brings, 'title' => '转账']);
    }

    public function create()
    {
        $account_id = Auth::user()->account_id;
        $account = Account::find($account_id);
        $balance = Balance::where('account_id', $account_id)->first();
        $accounts = Customer::where('account_id', $account_id)->get();

        return view('bring.create', [
            'account' => $account,
            'balance' => $balance,
            'accounts' => $accounts,
            'title' => '转账'
        ]);
    }

    public function store(Request $request)
    {
        $account_id = Auth::user()->account_id;
        $rules = [
            'amount' => 'required',
            'collection_account' => 'required'
        ];

        $messages = [
            'amount.required' => '请输入金额',
            'collection_account.required' => '请选择对方账户'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'messages' => $validator->messages()->toArray()
            ]);
        }

        $amount = $request->get('amount');
        $collection_account = $request->get('collection_account');
        $balance_primary = Balance::where('account_id', $account_id)->first();

        if ($amount > $balance_primary->amount) {
            return response()->json([
                'status' => 'success',
                'message' => '对不起，您的余额不足'
            ]);
        }

        $zhuanzhang = ZhuanzhangHistory::create([
            'account_id' => $account_id,
            'amount' => $amount,
            'collection_account' => $collection_account
        ]);

        $balance = Balance::where('account_id', $collection_account)->first();
        if ($balance) {
            $balance->amount = $balance->amount + $amount;
            $balance->save();
        } else {
            $balance = new Balance();
            $balance->account_id = $collection_account;
            $balance->amount = $amount;
            $balance->save();
        }


        $balance_primary->amount = $balance->amount- $amount;
        $balance->save();

        return response()->json([
            'status' => 'success',
            'message' => '转账成功',
            'redirectUrl' => '/'
        ]);
    }
}
