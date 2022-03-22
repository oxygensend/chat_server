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



//Auth
Route::post('login', 'App\Http\Controllers\Auth\LoginController@login');
Route::get('login',  'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
Route::post('logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');
Route::get('register', 'App\Http\Controllers\Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'App\Http\Controllers\Auth\RegisterController@register');

Route::get('/', [App\Http\Controllers\RoomController::class, 'choose'])->name('home');
Route::get('/create', [App\Http\Controllers\RoomController::class, 'create'])->name('create');
Route::get('/{room}', [App\Http\Controllers\RoomController::class, 'show'])->name('show');
