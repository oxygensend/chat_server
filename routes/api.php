<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function () {
    Route::apiResource('rooms', 'App\Http\Controllers\Api\RoomController');
    Route::patch('/rooms/{room}', 'App\Http\Controllers\Api\RoomController@connect')->name('connect')->middleware('room-token');
    Route::delete('/rooms/{room}', 'App\Http\Controllers\Api\RoomController@disconnect')->name('disconnect');
    Route::get('/rooms/{room}/messages', 'App\Http\Controllers\Api\MessageController@index');
    Route::post('/rooms/{room}/messages', 'App\Http\Controllers\Api\MessageController@store');
    Route::get('/rooms/{room}/users', 'App\Http\Controllers\Api\UserController@index');
});
