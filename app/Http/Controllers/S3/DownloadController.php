<?php

namespace App\Http\Controllers\S3;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 

class DownloadController extends Controller
{
    public function download($file)
    {
        if (!Storage::disk('s3')->exists($file)) {
            return back()->withErrors(['error' => 'File not found.']);
        }

        return Storage::disk('s3')->download($file);
    }
}