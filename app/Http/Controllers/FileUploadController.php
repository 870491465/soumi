<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class FileUploadController extends Controller
{
    //
    public function store(Request $request)
    {
        $type = $request->get('type');
        $user_name = Auth::user()->name;
        $file = Input::file('file');
        // dd($file);
        $id = Input::get('id');
        $name=$request->get('filename');

        $allowed_extensions = ["png", "jpg", "gif","jpeg"];
        if ($file->getClientOriginalExtension() && !in_array($file->getClientOriginalExtension(), $allowed_extensions)) {
            return ['error' => 'You may only upload png, jpg or gif.'];
        }

        $destinationPath ="";
        $destinationPath='uploads/'.$user_name.'/';

        $extension = $file->getClientOriginalExtension();
        $fileName =str_random(10);
        $fileNameFull=$fileName.'@.'.$extension;
        $filethumb=$fileName.'_thumb'.'.'.$extension;
        $file->move($destinationPath, $fileNameFull);
        //Image::configure(array('driver' => 'imagick'));
        //$manager = new ImageManager(array('driver' => 'imagick'));
        $path = public_path($destinationPath . $filethumb);
        return response()->json(
            [
                'success' => true,
                'pic' =>asset($destinationPath.$fileNameFull),
                'id' => $id,
                'type' => $type
            ]
        );
    }
}
