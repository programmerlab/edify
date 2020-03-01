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

Route::post('login', function (App\Admin $user) {
      
    // $credentials = ['email' => Input::get('email'), 'password' => Input::get('password')];
    $credentials = ['email' => 'kundan@gmail.com', 'password' => 123456];

    // $auth = auth()->guard('web');
    // Session::set('role','admin');
    $admin_auth = auth()->guard('admin');
    $user_auth =  auth()->guard('web'); //Auth::attempt($credentials);

    if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])){
        echo "aaaaaaaa"; exit;
        // return Redirect::to('admin');
    } else {
        echo "bbbbbbb"; exit;
        return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors(['message'=>'Invalid email or password. Try again!']);
    }
});

Route::get('/', 'FrontEndController@index');
Route::post('signup', 'FrontEndController@signup')->name('custom.register');
