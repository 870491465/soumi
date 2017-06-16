<?php

namespace App\Http\Controllers\Admin;

use App\Models\Declaration;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeclarationController extends Controller
{
    //
    public function index()
    {
        $declarations = Declaration::where('status_id', 1)->paginate(15);
        $declaration = Declaration::find(1);

        return view('admin.declaration.index', ['declarations' => $declarations]);
    }
}
