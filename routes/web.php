<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/toastr', [NotificationController::class, 'index']);
Route::get('/success', [NotificationController::class, 'success']);
Route::get('/error', [NotificationController::class, 'error']);
Route::get('/info', [NotificationController::class, 'info']);
Route::get('/warning', [NotificationController::class, 'warning']);
