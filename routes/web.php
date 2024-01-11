<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
use App\Http\Controllers\S3Controller;

Route::get('/', function () {
    return view('userinterface');
});

Route::get('/userinterface', function () {
    return view('userinterface');
});

Route::get('/userinterface', [S3Controller::class, 'showUserInterface'])->name('user.interface');
Route::post('/upload-file', [S3Controller::class, 'uploadFile'])->name('upload.file');
Route::post('/show-objects', [S3Controller::class, 'showObjects'])->name('show.objects');
Route::post('/retrieve-file', [S3Controller::class, 'retrieveFile'])->name('retrieve.file');
Route::post('/delete-file', [S3Controller::class, 'deleteFile'])->name('delete.file');
Route::post('/download-file', [S3Controller::class, 'downloadFile'])->name('download.file');
