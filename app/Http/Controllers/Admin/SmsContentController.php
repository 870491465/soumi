<?php

namespace App\Http\Controllers\Admin;

use App\Models\SmsContent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SmsContentController extends Controller
{
    //

    public function show()
    {
        $sms_content = SmsContent::first();

        return view('admin.setting.smscontent', ['sms_content' => $sms_content]);
    }

    public function store(Request $request)
    {
        $content = $request->get('smscontent');
        $sms_content = SmsContent::first();
        $sms_content->content = $content;
        $sms_content->save();
        return response()->json([
            'status' => 'success',
            'message' => '编辑成功'
        ]);
    }
}
