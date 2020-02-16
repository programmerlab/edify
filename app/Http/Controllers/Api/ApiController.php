<?php

namespace App\Http\Controllers\Api;
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
    public function customerLogin(Request $request)
    {
      
       // echo "Email:".$request->email;
        $input = $request->all();
       // print_r ($input);
        $validator = Validator::make($request->all(), [
                    'email' => 'required',
                     'loginType' => 'required'
                ]);
        if ($validator->fails()) {
            $error_msg = [];
            foreach ($validator->messages()->all() as $key => $value) {
                array_push($error_msg, $value);
            }
            if ($error_msg) {
                return array(
                    'app_status' => false,
                    'code' => 201,
                    'msg' => $error_msg[0],
                    'user_data' => $request->all()
                );
            }
        }
      
         $usermodel  = null;
        if($request->loginType =='gauth')   {
             $usermodel  = \DB::table('users')->where('email' , $request->email)->first();
        } else if($request->loginType =='facebookauth')   {
             $usermodel  = \DB::table('users')->where('email' , $request->email)->first();
        } else  if($request->loginType =='manualauth')   {
             $usermodel  = \DB::table('users')
                            ->where('email' , $request->email)
                            ->where('password' , $request->password)
                            ->first();
        } 
      
        if($usermodel){
            $user_input['first_name'] = $usermodel->first_name;
            $user_input['last_name'] = $usermodel->last_name;
            $user_input['user_email'] = $usermodel->email;
            $user_input['user_id'] = $usermodel->id;
            $user_input['mobile_number'] = $usermodel->phone;
            return response()->json(["app_status" => true, "code" => 200, "msg" => "Successfully logged in.", 'user_data' => $user_input ]);
            
        }else{   
            return response()->json(["app_status" => false, "code" => 401, "msg" => "User doesn't exsist.", 'user_data' => $input]);  
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


 public function getActiveEditors(Request $request)
    {
      
       // echo "Email:".$request->email;
        $input = $request->all();
        //print_r ($input);
        $validator = Validator::make($request->all(), [
                    'per_page' => 'required',
                     'page' => 'required'
                ]);
        if ($validator->fails()) {
            $error_msg = [];
            foreach ($validator->messages()->all() as $key => $value) {
                array_push($error_msg, $value);
            }
            if ($error_msg) {
                return array(
                    'app_status' => false,
                    'code' => 201,
                    'msg' => $error_msg[0],
                    'user_data' => $request->all()
                );
            }
        }
      
             $usermodel  = \DB::table('users')
                            ->where('role_type' , 5)
                            ->get();
         
      
        if($usermodel){
            $editorsList =  array();
    
             foreach($usermodel as $editors){
                    $editorsList[] = array('id' => $editors->id,'avatar' => $editors->profile_image,'first_name' => $editors->first_name,'last_name' => $editors->last_name); 
             }
            
            return response()->json(["app_status" => true, "code" => 200, "msg" => "Successfully logged in.", 'data' => $editorsList]);
        }else{   
            return response()->json(["app_status" => false, "code" => 401, "msg" => "User doesn't exsist.", 'user_data' => $input]);  
        }
    }



 public function getBanners(Request $request)
    {
      
       // echo "Email:".$request->email;
        $input = $request->all();
        //print_r ($input);
        $validator = Validator::make($request->all(), [
                    'per_page' => 'required',
                     'page' => 'required'
                ]);
        if ($validator->fails()) {
            $error_msg = [];
            foreach ($validator->messages()->all() as $key => $value) {
                array_push($error_msg, $value);
            }
            if ($error_msg) {
                return array(
                    'app_status' => false,
                    'code' => 201,
                    'msg' => $error_msg[0],
                    'user_data' => $request->all()
                );
            }
        }
      
             $usermodel  = \DB::table('banners')
                            ->where('status' , 1)
                            ->get();
         
      
        if($usermodel){
            $editorsList =  array();
    
             foreach($usermodel as $editors){
                    $editorsList[] = array('id' => $editors->id,'avatar' => $editors->photo,'banner_title' => $editors->title); 
             }
            
            return response()->json(["app_status" => true, "code" => 200, "msg" => "Successfully logged in.", 'data' => $editorsList]);
        }else{   
            return response()->json(["app_status" => false, "code" => 401, "msg" => "User doesn't exsist.", 'user_data' => $input]);  
        }
    }


 public function getAllPosts(Request $request)
    {
      
       // echo "Email:".$request->email;
        $input = $request->all();
        //print_r ($input);
        $validator = Validator::make($request->all(), [
                    'per_page' => 'required',
                     'page' => 'required'
                ]);
        if ($validator->fails()) {
            $error_msg = [];
            foreach ($validator->messages()->all() as $key => $value) {
                array_push($error_msg, $value);
            }
            if ($error_msg) {
                return array(
                    'app_status' => false,
                    'code' => 201,
                    'msg' => $error_msg[0],
                    'user_data' => $request->all()
                );
            }
        }
      
             $usermodel  = \DB::table('editor_profiles')
                            ->get();
         
      
        if($usermodel){
            $editorsList =  array();
    
             foreach($usermodel as $editors){
                   $imageUrl = "https://edifyartist.com/storage/uploads/editorPortfolio/".$editors->image_name;
                   $autherName = "Photoshop"; //SoftName
                    $subTitle = "Best Kalpanic image 4ever";  // Category Name 
                    $editorImage = "https://edifyartist.com/storage/uploads/banners/manoj_profile.png";  //Editor Image 
                    
                    $editorsList[] = array('id' => $editors->id,'avatar' =>  $imageUrl,'post_title' => $editors->title,'total_likes' => $editors->total_likes,"auther_name"=>$autherName,"sub_title"=>$subTitle,"profile_image"=>$editorImage ); 
             }
            
            return response()->json(["app_status" => true, "code" => 200, "msg" => "Successfully logged in.", 'data' => $editorsList]);
        }else{   
            return response()->json(["app_status" => false, "code" => 401, "msg" => "User doesn't exsist.", 'user_data' => $input]);  
        }
    }

public function getAllLikes(Request $request)
    {
      
       // echo "Email:".$request->email;
        $input = $request->all();
        //print_r ($input);
        $validator = Validator::make($request->all(), [
                    'per_page' => 'required',
                     'page' => 'required'
                ]);
        if ($validator->fails()) {
            $error_msg = [];
            foreach ($validator->messages()->all() as $key => $value) {
                array_push($error_msg, $value);
            }
            if ($error_msg) {
                return array(
                    'app_status' => false,
                    'code' => 201,
                    'msg' => $error_msg[0],
                    'user_data' => $request->all()
                );
            }
        }
      
             $usermodel  = \DB::table('editor_profiles')
                            ->get();
         
      
        if($usermodel){
            $editorsList =  array();
    
             foreach($usermodel as $editors){
                   $imageUrl = "https://edifyartist.com/storage/uploads/editorPortfolio/".$editors->image_name;
                   $autherName = "Photoshop"; //SoftName
                    $subTitle = "Best Kalpanic image 4ever";  // Category Name 
                    $editorImage = "https://edifyartist.com/storage/uploads/banners/manoj_profile.png";  //Editor Image 
                    
                    $editorsList[] = array('id' => $editors->id,'avatar' =>  $imageUrl,'post_title' => $editors->title,'total_likes' => $editors->total_likes,"auther_name"=>$autherName,"sub_title"=>$subTitle,"profile_image"=>$editorImage ); 
             }
            
            return response()->json(["app_status" => true, "code" => 200, "msg" => "Successfully logged in.", 'data' => $editorsList]);
        }else{   
            return response()->json(["app_status" => false, "code" => 401, "msg" => "User doesn't exsist.", 'user_data' => $input]);  
        }
    }


public function getMyOrders(Request $request)
    {
      
       // echo "Email:".$request->email;
        $input = $request->all();
        //print_r ($input);
        $validator = Validator::make($request->all(), [
                    'per_page' => 'required',
                     'page' => 'required'
                ]);
        if ($validator->fails()) {
            $error_msg = [];
            foreach ($validator->messages()->all() as $key => $value) {
                array_push($error_msg, $value);
            }
            if ($error_msg) {
                return array(
                    'app_status' => false,
                    'code' => 201,
                    'msg' => $error_msg[0],
                    'user_data' => $request->all()
                );
            }
        }
      
             $usermodel  = \DB::table('editor_profiles')
                            ->get();
         
      
        if($usermodel){
            $editorsList =  array();
    
             foreach($usermodel as $editors){
                   $imageUrl = "https://edifyartist.com/storage/uploads/editorPortfolio/".$editors->image_name;
                   $autherName = "Photoshop"; //SoftName
                    $subTitle = "Best Kalpanic image 4ever";  // Category Name 
                    $editorImage = "https://edifyartist.com/storage/uploads/banners/manoj_profile.png";  //Editor Image 
                    
                    $editorsList[] = array('id' => $editors->id,'avatar' =>  $imageUrl,'post_title' => $editors->title,'total_likes' => $editors->total_likes,"auther_name"=>$autherName,"sub_title"=>$subTitle,"profile_image"=>$editorImage ); 
             }
            
            return response()->json(["app_status" => true, "code" => 200, "msg" => "Successfully logged in.", 'data' => $editorsList]);
        }else{   
            return response()->json(["app_status" => false, "code" => 401, "msg" => "User doesn't exsist.", 'user_data' => $input]);  
        }
    }

    public function editor_portfolio( Request $request)
    {
       
//        $data = EditorPortfolio::all();
//         $data->transform(function($item,$key){
//         $category = Category::where('id',$item->category_name)->get();
//         $software_editor = SoftwareEditor::where('id', $item->software_editor)->get();
//         $item->cat_name = $category[0]['category_name'];
//         $item->software_name = $software_editor[0]['software_name'];
//         $item['price'] = '80';
//          return $item;
//         });
        
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
