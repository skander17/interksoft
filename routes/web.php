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

Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('auth');
Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('auth');
Route::get('/auth/jwt', 'App\Http\Controllers\AuthController@getJWT')->middleware('auth');

Route::group(['prefix' => 'report', 'middleware'=>'auth'], function () {

	Route::get('users','App\Http\Controllers\UserController@report');
	Route::get('clients','App\Http\Controllers\ClientController@report');
	Route::get('airports','App\Http\Controllers\AirportController@report');
	Route::get('airlines','App\Http\Controllers\AirlineController@report');
	Route::get('countries','App\Http\Controllers\CountryController@report');

	Route::get('tickets','App\Http\Controllers\TicketController@report');

});

Route::group(['middleware' => 'auth'], function () {

	Route::resource('users', 'App\Http\Controllers\UserController', ['only' => ['index']]);

	Route::resource('clients', 'App\Http\Controllers\ClientController', ['only' => ['index']]);

	Route::resource('airlines', 'App\Http\Controllers\AirlineController', ['only' => ['index']]);

	Route::resource('airports', 'App\Http\Controllers\AirportController', ['only' => ['index']]);

	Route::resource('countries', 'App\Http\Controllers\CountryController', ['only' => ['index']]);

    Route::resource('tickets', 'App\Http\Controllers\TicketController', ['only' => ['index']]);


	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);



	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);


	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});
