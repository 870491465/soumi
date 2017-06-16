<?php

namespace App\Http\Controllers\Admin;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    //
    public function index()
    {
        $accounts = Account::where('status','>', 0)->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.customer.index', ['accounts' => $accounts]);
    }

    public function search(Request $request)
    {
        $mobile = $request->get('mobile');
        $name = $request->get('name');
        $business_name = $request->get('business_name');

        $builder = Account::paginate(15);
        if ($name) {

            $accounts = $builder->where('name', '=', $name);
        }
        if ($mobile) {
            $accounts = $builder->where('mobile', '=', $mobile);
        }
        if ($business_name) {
            $accounts = $builder->where('business_name', '=', $business_name);
        }
        return view('admin.customer.index', ['accounts' => $accounts]);
    }

    public function store()
    {

    }

    public function show($id)
    {
        $account = Account::find($id);
        if ($account) {
            return view('admin.authentication.detail', ['account' => $account]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => '资源不存在'
            ]);
        }
    }
}
