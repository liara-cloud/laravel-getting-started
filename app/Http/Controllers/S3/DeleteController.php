<?php

namespace App\Http\Controllers\S3;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 

class DeleteController extends Controller
{
    public function delete($file)
    {
        if (!Storage::disk('s3')->exists($file)) {
            return back()->withErrors(['error' => 'File not found.']);
        }

        Storage::disk('s3')->delete($file);

        return redirect()->route('s3.index')->with('success', 'File deleted successfully.');
    }
}
