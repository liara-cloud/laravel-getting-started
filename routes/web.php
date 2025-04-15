<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\S3\StorageController;
use App\Http\Controllers\S3\UploadController;
use App\Http\Controllers\S3\DownloadController;
use App\Http\Controllers\S3\DeleteController;
use App\Http\Controllers\S3\PresignedController;

Route::prefix('s3-storage')->group(function () {
    Route::get('/', [StorageController::class, 'index'])->name('s3.index');
    Route::post('/upload', [UploadController::class, 'upload'])->name('s3.upload');
    Route::get('/download/{file}', [DownloadController::class, 'download'])->name('s3.download');
    Route::delete('/delete/{file}', [DeleteController::class, 'delete'])->name('s3.delete');
    Route::get('/presigned/{file}', [PresignedController::class, 'generatePresignedUrl'])->name('s3.presigned');
});