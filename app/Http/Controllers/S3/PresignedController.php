<?php

namespace App\Http\Controllers\S3;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 

class PresignedController extends Controller
{
    public function generatePresignedUrl($file)
    {
        if (!Storage::disk('s3')->exists($file)) {
            return back()->withErrors(['error' => 'File not found.']);
        }

        $url = Storage::disk('s3')->temporaryUrl($file, now()->addHours(1));

        return response()->json(['url' => $url]);
    }
}
