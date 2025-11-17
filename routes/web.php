<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;

Route::get('/', [PdfController::class, 'showForm'])->name('home');
Route::post('/generate-pdf', [PdfController::class, 'generatePdf'])->name('generate.pdf');
