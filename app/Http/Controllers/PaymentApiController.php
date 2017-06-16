<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\DepositStatus;
use Illuminate\Http\Request;

class PaymentApiController extends Controller
{
    //
    public function store(Request $request)
    {
        $deposit_id = $request->get('deposit_id');
        $deposit = Deposit::where('deposit_id', $deposit_id)->first();
        if ($deposit) {
            $deposit->status_id = DepositStatus::SUCCESS;
            $deposit->save();
            return response()->json(['status' => 'success']);
        }
    }
}
