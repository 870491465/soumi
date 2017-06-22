<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //

    public function index()
    {
        $secret_key = env('SECRET_KEY');
        $user_info = array('鲍加志', '340322198309210815', $secret_key, '13151523039');
        $user = implode('|', $user_info);
        dd(md5($user));
        return view('index');
    }
}
