<?php

namespace App\Http\Controllers\Api;

use Modules\Admin\Models\EditorPortfolio;
use Modules\Admin\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class ApiController extends BaseController
{
   /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
    	 
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;

        return $this->sendResponse($success, 'User register successfully.');

    }
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            $success['name'] =  $user->name;
            return $this->sendResponse($success, 'User login successfully.');

        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 

    }
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return $this->sendResponse($users, 'Products retrieved successfully.');
    }

    // public function editor_portfolio()
    // {
    //    $data = EditorPortfolio::all();
    //     foreach($data as $cat)
    //     {
    //         $cat_id = $cat['category_name'];
    //         $cat_name = Category::where('id',$cat_id)->get();   
    //         $data['new_name'] = $cat_name[0]['category_name'];
    //     }
       
    //    return $this->sendResponse($data, 'Products retrieved successfully.');
    // }

    public function editor_portfolio()
    {
       $data = EditorPortfolio::all();
        $data->transform(function($item,$key){

        $category = Category::where('id',$item['category_name'])->get();
        $item['cat_name'] = $category[0]['category_name'];

         return $item;
        });
       
       return $this->sendResponse($data, 'Products retrieved successfully.');
    }
}
