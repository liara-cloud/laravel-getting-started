<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class S3Controller extends Controller
{
    public function showUserInterface()
    {
        return view('userinterface');
    }

    public function uploadFile(Request $request)
    {
        $request->validate([
            'upload_file' => 'required|max:2048', // Adjust the file size validation as needed
        ]);

        $file = $request->file('upload_file');
        $fileName = $file->getClientOriginalName();

        Storage::disk('liara')->put($fileName, file_get_contents($file));

        return redirect()->route('user.interface')->with('success', 'File uploaded successfully');
    }

    public function showObjects()
    {
        $objects = Storage::disk('liara')->allFiles('');
    
        $files = [];
        foreach ($objects as $object) {
            $files[] = [
                'name' => $object,
                'download_link' => Storage::disk('liara')->temporaryUrl($object, now()->addMinutes(5)),
            ];
        }
    
        return view('userinterface', ['files' => $files]);
    }
    

    public function downloadFile(Request $request)
    {
        $fileName = $request->input('download_file');
        return Storage::disk('liara')->download($fileName);
    }

    public function deleteFile(Request $request)
    {
        $fileName = $request->input('delete_file');
        Storage::disk('liara')->delete($fileName);
        
        return redirect()->route('user.interface')->with('success', 'File deleted successfully');
    }
}
