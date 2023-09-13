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
    return view('welcome');
});

Route::get('/upload-file'  ,   [S3Controller::class, 'upload_file']  );
Route::get('/retrieve-file',   [S3Controller::class, 'retrieve_file']);
Route::get('/download-file',   [S3Controller::class, 'download_file']);
Route::get('/list-files'   ,   [S3Controller::class, 'list_files']   );
Route::get('/delete-file'  ,   [S3Controller::class, 'delete_file']  );

