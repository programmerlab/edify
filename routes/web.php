<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::post('login', 'FrontEndController@login');
Route::get('login', 'FrontEndController@login');
Route::get('/', 'FrontEndController@index');
Route::post('signup', 'FrontEndController@signup')->name('custom.register');
