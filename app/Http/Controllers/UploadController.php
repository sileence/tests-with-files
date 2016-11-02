<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function create()
    {
        return view('upload');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image',
        ]);

        Image::create([
            'title' => $request->get('title'),
            'image' => $request->file('image')->store('images'),
        ]);

        return 'Done!';
    }
}
