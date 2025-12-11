<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class S3FileController extends Controller
{
    public function index()
    {
        try {
            $files = Storage::disk('s3')->allFiles();
            
            $fileDetails = collect($files)->map(function ($file) {
                return [
                    'name' => basename($file),
                    'path' => $file,
                    'size' => Storage::disk('s3')->size($file),
                    'lastModified' => Storage::disk('s3')->lastModified($file),
                    'url' => Storage::disk('s3')->url($file),
                ];
            })->sortByDesc('lastModified')->values();

            return view('s3-manager', [
                'files' => $fileDetails,
                'bucket' => config('filesystems.disks.s3.bucket'),
            ]);
        } catch (\Exception $e) {
            return view('s3-manager', [
                'files' => collect([]),
                'bucket' => config('filesystems.disks.s3.bucket'),
                'error' => 'Error connecting to S3: ' . $e->getMessage(),
            ]);
        }
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', 
        ]);

        try {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            Storage::disk('s3')->put($filename, file_get_contents($file));

            return response()->json([
                'success' => true,
                'message' => 'File uploaded successfully',
                'filename' => $filename,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function download($filename)
    {
        try {
            if (!Storage::disk('s3')->exists($filename)) {
                abort(404, 'File not found');
            }

            return Storage::disk('s3')->download($filename);
        } catch (\Exception $e) {
            abort(500, 'Download failed: ' . $e->getMessage());
        }
    }

    public function delete($filename)
    {
        try {
            if (!Storage::disk('s3')->exists($filename)) {
                return response()->json([
                    'success' => false,
                    'message' => 'File not found',
                ], 404);
            }

            Storage::disk('s3')->delete($filename);

            return response()->json([
                'success' => true,
                'message' => 'File deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Delete failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getTempUrl($filename)
    {
        try {
            if (!Storage::disk('s3')->exists($filename)) {
                return response()->json([
                    'success' => false,
                    'message' => 'File not found',
                ], 404);
            }

            $url = Storage::disk('s3')->temporaryUrl(
                $filename,
                now()->addHour()
            );

            return response()->json([
                'success' => true,
                'url' => $url,
                'expires' => 'in 1 hour',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate temporary URL: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getPermanentUrl($filename)
    {
        try {
            if (!Storage::disk('s3')->exists($filename)) {
                return response()->json([
                    'success' => false,
                    'message' => 'File not found',
                ], 404);
            }

            $url = Storage::disk('s3')->url($filename);

            return response()->json([
                'success' => true,
                'url' => $url,
                'type' => 'permanent',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate permanent URL: ' . $e->getMessage(),
            ], 500);
        }
    }
}