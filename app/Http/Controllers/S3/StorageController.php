<?php

namespace App\Http\Controllers\S3;

use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class StorageController extends Controller
{
    public function index()
    {
        $files = Storage::disk('s3')->allFiles();
        $buckets = ['default' => config('filesystems.disks.s3.bucket')]; 

        return view('s3-storage', compact('files', 'buckets'));
    }
}