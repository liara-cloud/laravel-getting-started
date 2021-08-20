<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUpload extends Controller
{
    public function showForm()
    {
        $files = collect(Storage::files('public/uploads'))->map(function ($file) {
            return Str::replaceFirst('public/uploads/', '', $file);
        });
        return view('upload', ['files' => $files]);
    }

    public function uploadFile(Request $req)
    {
        $req->validate([
            'file' => 'required|mimes:txt,png,jpeg,jpg,gif|max:2048'
        ]);

        $fileModel = new File;

        if ($req->file()) {
            $fileName = time() . '_' . $req->file->getClientOriginalName();
            $filePath = $req->file('file')->storeAs('uploads', $fileName, 'public');

            $fileModel->name = time() . '_' . $req->file->getClientOriginalName();
            $fileModel->file_path = '/storage/' . $filePath;
            $fileModel->save();

            return back()
                ->with('success', 'File has been uploaded.')
                ->with('file', $fileName);
        }
    }
}
