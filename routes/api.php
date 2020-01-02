<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('app', function (Request $request) {
	     Route::get('users', 'Api\ApiController@index');

});

Route::middleware('auth:api')->group( function () {

    Route::get('user', 'Api\ApiController@index');
});



 
Route::post('register', 'Api\ApiController@register');
Route::post('login', 'Api\ApiController@login');
     