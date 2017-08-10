<?php

namespace App\Http\Controllers\Admin;

use App\Models\Account;
use App\Models\Transfer;
use App\Models\TransferStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class TransferController extends Controller
{
    //

    public function index()
    {
        $transfers = Transfer::orderBy('created_at', 'asc')->orderBy('status_id', 'asc')->paginate(15);
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

    public function update($account_id, $id)
    {
        $transfer = Transfer::where('id', $id)->where('account_id', $account_id)->first();
        if ($transfer) {
            $transfer->status_id = TransferStatus::SUCCESS;
            $transfer->save();
            return response()->json([
                'status' => 'success',
                'message' => '处理完成',
                'redirectUrl' => ''
            ]);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => '处理失败'
            ]);
        }
    }

    public function export()
    {
        $transfers = Transfer::where('status_id', TransferStatus::PENDING)->get();
        Excel::create(Carbon::now()->toDateString().'提现信息表', function ($excel) use ($transfers) {
            $excel->setTitle('提款信息表');
            // Chain the setters
            $excel->sheet('transfer_sheet_1', function ($sheet) use ($transfers) {

                $sheet->row(1, [
                    '提款人',
                    '提款金额',
                    '银行',
                    '账户',
                    '开户行',
                    '提款日期'
                ]);
                $i = 2;
                foreach($transfers as $transfer)
                {
                    if ($transfer->account->user->role_id == 3 || $transfer->account->user->role_id == 4)
                    {
                        if(Carbon::now()->addDay(1)->diffInDays($transfer->created_at)>= 1)
                        {
                            $sheet->row($i, [
                                $transfer->account->person_name,
                                $transfer->amount,
                                $transfer->bankInfo->bank_name,
                                $transfer->bankInfo->card_no." ",
                                $transfer->bankInfo->open_point,
                                $transfer->created_at
                            ]);
                        }
                    } else {
                        if(Carbon::now()->addDay(1)->diffInDays($transfer->created_at)>=15) {
                            $sheet->row($i, [
                                $transfer->account->person_name,
                                $transfer->amount,
                                $transfer->bankInfo->bank_name,
                                $transfer->bankInfo->card_no." ",
                                $transfer->bankInfo->open_point,
                                $transfer->created_at
                            ]);
                        }

                    }

                    $i++;
                }
                // Set gray background on first row
                $sheet->row(1, function ($row) {
                    $row->setBackground('#f5f5f5');
                });
            });
        })->export('xls');

    }

    public function transferSuccess()
    {
        $transfers = Transfer::where('status_id', TransferStatus::PENDING)->get();
        foreach($transfers as $transfer)
        {
            $transfer_id = $transfer->id;
            $transfer_update = Transfer::find($transfer_id);

            if ($transfer->account->user->role_id == 3 || $transfer->account->user->role_id == 4)
            {
                if(Carbon::now()->addDay(1)->diffInDays($transfer->created_at)>= 1)
                {
                    $transfer_update->status_id = TransferStatus::SUCCESS;
                    $transfer_update->save();
                }
            } else {
                if(Carbon::now()->addDay(1)->diffInDays($transfer->created_at)>= 15) {
                    $transfer_update->status_id = TransferStatus::SUCCESS;
                    $transfer_update->save();
                }
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => '完成今日提现',
            'redirectUrl' => ''
        ]);
    }
}
