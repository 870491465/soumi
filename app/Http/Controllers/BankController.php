<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BankController extends Controller
{
    //
    public function show()
    {
        $account_id = Auth::user()->account_id;
        $account = Account::find($account_id);
        return view('bank.index', $account);
    }

    public function store(Request $request)
    {
        $rules = [
            'card_no' => 'required',
            'bank_name' => 'required',
        ];
        $messages = [
          'card_no.required' => '请输入银行卡号',
            'bank_name.required' => '请选择所属银行'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'messages' => $validator->messages()->toArray()
            ]);
        }

        $account_id = Auth::user()->account_id;
        $account = Account::find($account_id);
        $card_no = $request->get('card_no');
        $bank_name = $request->get('bank_name');
        $open_point = $request->get('open_point');

        $bank = Bank::where('account_id', $account_id)->first();
        if (!$bank) {
            $bank = new Bank();
            $bank->account_id = $account_id;
        }
        $bank->person_name = $account->person_name;

        $bank->card_no = $card_no;
        $bank->bank_name = $bank_name;
        $bank->open_point = $open_point;
        $bank->save();

        return response()->json([
            'status' => 'success',
            'message' => '提交成功',
        ]);
    }
}
