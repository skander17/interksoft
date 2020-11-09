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
Auth::routes();

Route::middleware('auth')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth')->get('/users/{id}','App\Http\Controllers\UserController@show');
Route::middleware('auth')->put('/users/{id}','App\Http\Controllers\UserController@update');
Route::middleware('auth')->delete('/users/{id}','App\Http\Controllers\UserController@destroy');
Route::middleware('auth')->post('/users','App\Http\Controllers\UserController@store');


Route::resource('clients', 'App\Http\Controllers\ClientController', ['only' => ['show','store','update','destroy']]);



Route::resource('airports', 'App\Http\Controllers\AirportController', ['only' => ['show','store','update','destroy']]);
Route::resource('countries', 'App\Http\Controllers\CountryController', ['only' => ['show','store','update','destroy']]);
Route::resource('airlines', 'App\Http\Controllers\AirlineController', ['only' => ['show','store','update','destroy']]);
