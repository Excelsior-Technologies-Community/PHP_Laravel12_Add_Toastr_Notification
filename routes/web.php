<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/toastr', [NotificationController::class, 'index']);
Route::get('/success', [NotificationController::class, 'success']);
Route::get('/error', [NotificationController::class, 'error']);
Route::get('/info', [NotificationController::class, 'info']);
Route::get('/warning', [NotificationController::class, 'warning']);

Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::post('/toggle-status/{id}', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
    Route::post('/delete/{id}', [UserController::class, 'delete'])->name('users.delete');
    Route::post('/restore/{id}', [UserController::class, 'restore'])->name('users.restore');
    Route::post('/force-delete/{id}', [UserController::class, 'forceDelete'])->name('users.forceDelete');
    Route::get('/export', [UserController::class, 'exportCsv'])->name('users.export');
});