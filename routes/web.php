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
 
Route::get('login', 'FrontEndController@login');
Route::post('login', [ 'as' => 'login', 'uses' => 'FrontEndController@login']);
Route::get('logout', 'FrontEndController@logout');
Route::get('editortest', 'FrontEndController@editortest');	
Route::get('/', 'FrontEndController@index');
Route::post('signup', 'FrontEndController@signup')->name('custom.register');
Route::post('uploadtestimage', 'FrontEndController@UploadTestImages');
Route::post('forgotpassword', 'FrontEndController@ForgotPassword');
Route::get('editordashboard', 'DashboardController@index');
Route::get('mystories', 'DashboardController@MyStories');
Route::get('story/delete/{id}', 'DashboardController@storyDelete');
Route::get('document/delete/{id}', 'DashboardController@DocumentDelete');

Route::get('upload-document', 'DashboardController@uploadDocument');
Route::post('bankAccount', 'DashboardController@bankAccount');

Route::get('myaccount', 'DashboardController@MyAccount');
Route::get('postinfo', 'DashboardController@PostInfo');
Route::get('postupload', 'DashboardController@PostUpload');
Route::get('posts', 'DashboardController@Posts');
Route::get('post/delete/{id}', 'DashboardController@PostDelete');
Route::get('myorders', 'DashboardController@MyOrders');
Route::get('howitworks', 'DashboardController@HowItWorks');
Route::get('faq', 'DashboardController@Faq');
Route::get('termscondition', 'DashboardController@Tnc');
Route::post('update_editor_info', 'DashboardController@UpdateEditorInfo');
Route::post('uploadpost', 'DashboardController@UploadPost');
Route::post('uploadstories', 'DashboardController@UploadStories');
Route::post('uploadDocuments', 'DashboardController@uploadDocuments');
Route::post('logout', 'DashboardController@Logout');


Route::match(
    ['post','get'],
    '/{name}',
    [
        'as'   => 'contentspage',
        'uses' => 'FrontEndController@page',
    ]
    );
