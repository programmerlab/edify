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


// 
// Route::middleware('auth:api')->group( function () {
// 
//     Route::get('user', 'Api\ApiController@index');
// });
// 
// 
// 
//  
// Route::post('register', 'Api\ApiController@register');
// Route::post('login', 'Api\ApiController@login($request)');
// 
// // Ayush
// Route::get('test', 'Api\ApiController@test');
// Route::get('editor-portfolio', 'Api\ApiController@editor_portfolio');
// Route::get('get-banners', 'Api\ApiController@get_banners');
// Route::post('update', 'Api\ApiController@update');
// Route::get('active-editors', 'Api\ApiController@active_editors');
// Route::post('like-counts', 'Api\ApiController@like_counts');

// 
Route::group([
	    'prefix' => 'v2'
	], function()
    {

        //Apis used in customer application  
        Route::match(['post','get'],'member/customerLogin', 'Api\ApiController@customerLogin');
        Route::match(['post','get'],'member/registration', 'Api\ApiController@registration');
        
        Route::match(['post','get'],'member/getActiveEditors', 'Api\ApiController@getActiveEditors');
        Route::match(['post','get'],'member/getBanners', 'Api\ApiController@getBanners');
        Route::match(['post','get'],'member/getAllPosts', 'Api\ApiController@getAllPosts');
        Route::match(['post','get'],'member/getAllMyLikes', 'Api\ApiController@getAllMyLikes');
        Route::match(['post','get'],'member/postLikes', 'Api\ApiController@postLikes');
        
        Route::match(['post','get'],'member/getMyOrders', 'Api\ApiController@getMyOrders');
        
        
		
		 // if route not found
	    Route::any('{any}', function(){ 
				$data = [
							'status'=>0,
							'code'=>400,
							'message' => 'Bad request'
						];
				return \Response::json($data);

		});
       
});
     
     