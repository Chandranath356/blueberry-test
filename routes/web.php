<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\GoogleController;

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


Route::get('/',[CustomerController::class,'create']);

Route::post('/cutomer-import',[CustomerController::class,'store'])->name('customer.import');

Route::get('/cutomer-export',[CustomerController::class,'index'])->name('customer.export');

Route::get('google/login', [GoogleController::class, 'loginWithGoogle'])->name('login');

Route::get('auth/google/callback', [GoogleController::class, 'callbackFromGoogle'])->name('callback');

Route::get('/logout',[GoogleController::class, 'logout']);

