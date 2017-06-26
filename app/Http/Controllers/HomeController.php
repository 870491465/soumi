<?php

namespace App\Http\Controllers;

use App\Models\Bonus;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //

    public function index()
    {
        $account_id = Auth::user()->account_id;
        $message = Message::orderBy('created_at', 'desc')->first();
        $bonus = Bonus::where('account_id',$account_id)->orderBy('created_at', 'desc')->paginate(5);
        return view('index', ['bonuses' => $bonus, 'title' => '我的权益', 'message' => $message]);
    }
}
