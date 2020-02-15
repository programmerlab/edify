<?php

namespace App\Http\Controllers\Api;

use Modules\Admin\Models\EditorPortfolio;
use Modules\Admin\Models\SoftwareEditor;
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
            'first_name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $input = $request->all();
    //    print_r($input);exit;
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        // $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['first_name'] =  $user->name;

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
            // $success['token'] =  $user->createToken('MyApp')-> accessToken; 
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
        $category = Category::where('id',$item->category_name)->get();
        $software_editor = SoftwareEditor::where('id', $item->software_editor)->get();
        $item->cat_name = $category[0]['category_name'];
        $item->software_name = $software_editor[0]['software_name'];
        $item['price'] = '80';
         return $item;
        });
        
       return $this->sendResponse($data, 'Products retrieved successfully.');
    }

    public function get_banners()
    {
        $all_banners = \DB::table('banners')->get();

        $all_banners->transform(function($item,$key){
        $category = Category::where('id',$item->category_id)->get();      
        $item->cat_name = $category[0]['category_name'];
            return $item;
        });
        return response()
        ->json([
            'status' => "Banners retrieved successfully",
            'banners' => $all_banners
        ]);
    }

    public function update(Request $request)
    {
        $all_data = $request->all();
        $update_users = User::where('id',$request->id)->update($all_data);   
        if($update_users)
        {
            return response()
            ->json([
                'status' => 'Updated Succesfully',
            ]);
        }
        else{
            return response()
            ->json([
                'status' => 'Could not Updated',
            ]);
        }
    }

    public function active_editors()
    {
        $active_editors = User::where('role_type' , '5')->get();
        $active_editors ->transform(function($item,$key){
            $role_type = \DB::table('roles')->where('id' , $item->role_type)->get();
            $item->role_name = $role_type[0]->name;

            return $item;
        });

        return response()
        ->json([
            'status' => 'success',
            'active_editors' => $active_editors,
        ]);
    }

    public function like_counts(Request $request)
    {
         $id = $request->portfolio_id;
         $user_id = $request->user_id;
         $islike = $request->islike;
        //query 1
        //  $update_likes = EditorPortfolio::where('id',$id)->update([
        //     'total_likes' => \DB::raw('total_likes+1'),
        // ]);

        //query 2

        if($islike == "0")
        {
            $query = EditorPortfolio::find($id)->increment('total_likes');
            $insert = \DB::table('portfolio_likes_count')->insert([
                'user_id' => $user_id,
                'portfolio_id' => $id,
            ]);

            return response()
            ->json([
                'status' => "liked sucessfully",
            ]);
        }
        else{
            $query = EditorPortfolio::find($id)->decrement('total_likes');
            $delete = \DB::table('portfolio_likes_count')->where('user_id' , $user_id)->where('portfolio_id' , $id)->delete();

            return response()
            ->json([
                'status' => "unliked sucessfully",
            ]);
        }


    }
}
