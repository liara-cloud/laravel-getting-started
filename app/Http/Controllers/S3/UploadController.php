<?php

namespace App\Http\Controllers\S3;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
        ]);

        $file = $request->file('file');
        $path = $file->store('', 's3'); 

        
        $permanentLink = Storage::disk('s3')->url($path);

        return redirect()->route('s3.index')->with('success', 'File uploaded successfully.')
                         ->with('permanentLink', $permanentLink);
    }
}