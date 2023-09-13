<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class S3Controller extends Controller
{
    public function upload_file()
    {
        Storage::disk('liara')->put('example.txt', 'Hi I am Using Liara');
        echo "file uploaded successfully";
    }

    public function retrieve_file()
    {
        $contents = Storage::disk('liara')->get('example.txt');
        // $contents = Storage::json('example.json'); // if you have json
        echo "file retrieved successfully: ";
        echo $contents;
        
    }

    public function download_file()
    {
        return Storage::disk('liara')->download('liara-poster.png');
        echo "file downloaded successfully";
    }

    public function list_files()
    {
        $files = Storage::disk('liara')->Files("/");
        print_r($files);
    }

    public function delete_file()
    {
        Storage::disk('liara')->delete('example.txt');
        echo "file deleted successfully";
    }
}
