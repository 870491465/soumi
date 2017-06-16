<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Declaration;
use App\Models\DeclarationStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeclarationController extends Controller
{
    //

    public function index()
    {
        $account_id = Auth::user()->account_id;
        $account = Account::find($account_id);
        return view('declaration.index', ['account' => $account]);
    }

    public function create()
    {
        return view('declaration.create');
    }

    public function store(Request $request)
    {
        $account_id = Auth::user()->account_id;
        $amount = $request->get('amount');
        $invoice_pic = $request->get('invoice_pic');

        $declaration = Declaration::create(
          ['account_id' => $account_id, 'amount' => $amount,
              'invoice_pic' => $invoice_pic, 'status_id' => DeclarationStatus::PENDING]
        );
        if ($declaration) {
            return response()->json([
                'status' => 'success',
                'message' => '添加成功',
                'redirectUrl' => '/account/declaration'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => '失败'
            ]);
        }
    }
}
