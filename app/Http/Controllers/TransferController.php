<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transfer;
use App\Models\TransferStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TransferController extends Controller
{
    //

    public function index()
    {
        $account_id = Auth::user()->account_id;
        $account = Account::find($account_id);
        $transfers = Transfer::where('account_id', $account_id)->get();
        return view('transfer.index', ['transfers' => $transfers,
            'account' => $account, 'title' => '取款记录']);
    }

    public function create()
    {
        $account_id = Auth::user()->account_id;
        $account = Account::find($account_id);
        $transfers = Transfer::where('account_id', $account_id)->get();
        return view('transfer.create', ['transfers' => $transfers, 'account' => $account, 'title' => '取款']);
    }

    public function store(Request $request)
    {
        $rules = ['amount' => 'required', 'account_bank_id' => 'required'];
        $messages = ['amount.required' => '请输入取款金额', 'account_bank_id.required' => '请选择银行账户'];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'messages' => $validator->messages()->toArray()
            ]);
        }

        $account_id = Auth::user()->account_id;
        $amount = $request->get('amount');
        $available = $request->get('available');
        $account_bank_id = $request->get('account_bank_id');
        if ($amount > $available) {
            return response()->json([
               'status' => 'error',
                'messages' => ['amount' => '取款金额大于可取金额']
            ]);
        }

        $transfer = new Transfer();
        $transfer->account_id = $account_id;
        $transfer->amount = $amount;
        $transfer->account_bank_id = $account_bank_id;
        $transfer->status_id = TransferStatus::PENDING;
        $transfer->save();
        $role_id = Auth::user()->role_id;
        if ($role_id == 3 || $role_id == 4) {
            $day = "T+1";
        } else {
            $day = "T+15";
        }
        return response()->json([
            'status' => 'success',
            'message' => '提交成功,到帐周期为'.$day,
            'redirectUrl' => '/account/transfer'
        ]);
    }

}
