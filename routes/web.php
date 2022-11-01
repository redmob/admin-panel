<?php

use Illuminate\Support\Facades\Route;

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

use App\Http\Controllers\UserController;
//Route::view('/','auth.login');

Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);
Route::get('/', [UserController::class,'index'])->name('testing.newindex')->middleware('auth:admin');
Route::get('/dashboard', function () {return view('dashboard');});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
