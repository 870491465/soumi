<?php

namespace App\Http\Controllers\Admin;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthenticationController extends Controller
{
    //

    public function index()
    {
        $accounts =Account::where('status', 0)->get();
        return view('admin.authentication.index', ['accounts' => $accounts]);
    }

    public function store(Request $request, $id)
    {
        $status = $request->get('status');
        $account = Account::find($id);
        $account->status = $status;
        $account->save();
        return response()->json([
           'status' => 'success',
            'message' => '操作成功',
            'redirectUrl' => ''
        ]);
    }
}
