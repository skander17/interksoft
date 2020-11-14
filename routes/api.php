<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|-------------------------------------------------------                    method: "GET"
-------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login','App\Http\Controllers\AuthController@login');

Route::group(['middleware'=>'auth:api'],function (){

    Route::get('/user', function (Request $request) {
        return $request->user();
    });


    Route::resource('users', 'App\Http\Controllers\UserController', ['only' => ['show','store','update','destroy']]);


    Route::resource('clients', 'App\Http\Controllers\ClientController', ['only' => ['show','store','update','destroy']]);
    Route::get('search/clients', 'App\Http\Controllers\ClientController@search');

    Route::resource('airports', 'App\Http\Controllers\AirportController', ['only' => ['show','store','update','destroy']]);
    Route::get('search/airports', 'App\Http\Controllers\AirportController@search');

    Route::resource('countries', 'App\Http\Controllers\CountryController', ['only' => ['show','store','update','destroy']]);

    Route::resource('airlines', 'App\Http\Controllers\AirlineController', ['only' => ['show','store','update','destroy']]);
    Route::get('search/airlines', 'App\Http\Controllers\AirlineController@search');

    Route::resource('tickets', 'App\Http\Controllers\TicketController', ['only' => ['show','store','update','destroy']]);

});
