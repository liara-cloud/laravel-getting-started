<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileUpload;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/upload', [FileUpload::class, 'showForm']);
Route::post('/upload', [FileUpload::class, 'uploadFile'])->name('uploadFile');

Route::get('files/{file}', function ($file = null) {
    $path = storage_path() . '/' . 'app' . '/public/uploads/' . $file;
    if (file_exists($path))
        return response()->download($path);
});
