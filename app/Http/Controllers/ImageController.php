<?php

namespace App\Http\Controllers;

// در app/Http/Controllers/ImageController.php
use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function showUploadForm()
    {
        $images = Image::all();
        return view('image.upload', compact('images'));
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $image = $request->file('image');
        $imageName = time() . '.' . $image->extension();
        $image->move(public_path('uploads'), $imageName);

        $imageModel = new Image();
        $imageModel->filename = $imageName;
        $imageModel->save();

        return back()->with('success', 'Image Uploaded Successfully.')->with('image', $imageName);
    }
}
