<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\S3FileController;

Route::get('/', [S3FileController::class, 'index'])->name('s3.index');
Route::post('/upload', [S3FileController::class, 'upload'])->name('s3.upload');
Route::get('/download/{filename}', [S3FileController::class, 'download'])->name('s3.download');
Route::delete('/delete/{filename}', [S3FileController::class, 'delete'])->name('s3.delete');
Route::get('/temp-url/{filename}', [S3FileController::class, 'getTempUrl'])->name('s3.tempUrl');
Route::get('/permanent-url/{filename}', [S3FileController::class, 'getPermanentUrl'])->name('s3.permanentUrl');
