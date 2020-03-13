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
Route::post('uploadtestimage', 'FrontEndController@UploadTestImages');
Route::post('forgotpassword', 'FrontEndController@ForgotPassword');
Route::get('editordashboard', 'DashboardController@index');
Route::get('mystories', 'DashboardController@MyStories');
Route::get('myaccount', 'DashboardController@MyAccount');
Route::get('postinfo', 'DashboardController@PostInfo');
Route::get('postupload', 'DashboardController@PostUpload');
Route::get('posts', 'DashboardController@Posts');
Route::get('myorders', 'DashboardController@MyOrders');
Route::get('howitworks', 'DashboardController@HowItWorks');
Route::get('faq', 'DashboardController@Faq');
Route::get('termscondition', 'DashboardController@Tnc');
Route::post('update_editor_info', 'DashboardController@UpdateEditorInfo');
Route::post('uploadpost', 'DashboardController@UploadPost');
Route::post('uploadstories', 'DashboardController@UploadStories');
Route::post('logout', 'DashboardController@Logout');
