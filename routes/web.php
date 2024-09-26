<?php

use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

use App\Mail\TestEmail;
use Illuminate\Support\Facades\Mail;
Route::get('/send-test-email', function () {
    Mail::to('test@example.com')->send(new TestEmail());
    return 'Test email sent successfully!';
});
