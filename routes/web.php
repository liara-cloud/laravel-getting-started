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
use App\Http\Controllers\ImageController;

Route::get('/', [ImageController::class, 'showUploadForm']);
Route::post('/', [ImageController::class, 'uploadImage'])->name('image.upload');


Route::get('/', function () {
    return view('image/upload');
});
