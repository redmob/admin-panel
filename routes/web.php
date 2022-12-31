<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\AccountSetupController;

Route::view('/','auth.login');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/logout', [DashboardController::class, 'logout']);
Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/tutors', [TutorController::class,'index'])->name('tutor.index');
    Route::resource('users', UserController::class);
    Route::resource('account-setup', AccountSetupController::class);
});


