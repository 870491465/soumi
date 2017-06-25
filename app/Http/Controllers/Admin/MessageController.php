<?php

namespace App\Http\Controllers\Admin;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    //

    public function index()
    {
        $messages = Message::paginate(15);
        return view('admin.messages.index', ['messages' => $messages]);
    }


    public function store(Request $request)
    {
        $title = $request->get('title');
        $content = $request->get('content');
        Message::create(['title' => $title, 'content' => $content, 'status' => 0]);
        return response()->json([
            'status' => 'success',
            'messages' => '添加成功',
            'redirectUrl' => ''
        ]);
    }

    public function delete($id)
    {
        Message::find($id)->delete();
        return response()->json([
            'status' => 'success',
            'messages' => '删除成功',
            'redirectUrl' => ''
        ]);
    }


}
