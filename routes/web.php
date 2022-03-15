<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\RoomController::class, 'choose'])->name('home');
Route::get('/create', [App\Http\Controllers\RoomController::class, 'create'])->name('create');
Route::get('/{room}', [App\Http\Controllers\RoomController::class, 'show'])->name('show');
Route::post('/create', [App\Http\Controllers\RoomController::class, 'store'])->name('store');
