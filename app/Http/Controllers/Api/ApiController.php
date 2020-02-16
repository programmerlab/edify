<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\User;
use Illuminate\Support\Facades\Auth; 
use App\Models\Notification;
use Illuminate\Contracts\Encryption\DecryptException;
use Config,Mail,View,Redirect,Validator,Response; 
use Crypt,okie,Hash,Lang,JWTAuth,Input,Closure,URL; 
use App\Helpers\Helper as Helper;

use Modules\Admin\Models\EditorPortfolio;



class ApiController extends BaseController
{
   
    public function __construct(Request $request) {

        if ($request->header('Content-Type') != "application/json")  {
            $request->headers->set('Content-Type', 'application/json');
        }
    } 

    public function registration(Request $request)
    {   
        $input['first_name']    = $request->input('first_name');
        $input['last_name']     = $request->input('last_name'); 
        $input['email']         = $request->input('email'); 
        $input['password']      = Hash::make($request->input('password'));
        $input['role_type']     = $request->input('role_type'); ;
        $input['user_type']     = $request->input('user_type');
        $input['provider_id']   = $request->input('provider_id'); 

        $user = User::firstOrNew(['provider_id'=>$request->input('provider_id')]);
       
        if($request->input('user_id')){
            $u = $this->updateProfile($request,$user);
            return $u;
        } 

        if($input['user_type']=='googleauth' || $input['user_type']=='facebookauth' ){
                //Server side valiation
                $validator = Validator::make($request->all(), [
                   'first_name' => 'required',
                   'email' => 'required'
                ]);

        }else{
            //Server side valiation
            $validator = Validator::make($request->all(), [
               'first_name' => 'required',
               'email' => 'required|email|unique:users',
               'password' => 'required'
            ]);
        }
         

        /** Return Error Message **/
        if ($validator->fails()) {
            $error_msg      =   [];
            foreach ( $validator->messages()->all() as $key => $value) {
                        array_push($error_msg, $value);     
                    }
                    
            return Response::json(array(
                'status' => false,
                'code'=>201,
                'message' => $error_msg[0],
                'data'  =>  $request->all()
                )
            );
        } 
        
        $helper = new Helper;
        /** --Create USER-- **/
        $user = User::create($input); 

        $subject = "Welcome to edify! Verify your email address to get started";
        $email_content = [
                'receipent_email'=> $request->input('email'),
                'subject'=>$subject,
                'greeting'=> 'Yellotasker',
                'first_name'=> $request->input('first_name')
                ];

      //  $verification_email = $helper->sendMailFrontEnd($email_content,'verification_link');
        
        //dd($verification_email);

        $notification = new Notification;
        $notification->addNotification('user_register',$user->id,$user->id,'User register','');
       
        return response()->json(
                            [ 
                                "status"=>1,
                                "code"=>200,
                                "message"=>"Thank you for registration",
                                'data'=>$user
                            ]
                        );
    }


    public function updateProfile(Request $request,$userId)
    {      

        $user = User::find($userId); 

        if((User::find($userId))==null)
        {
            return Response::json(array(
                'status' => 0,
                'code' => 201,
                'message' => 'Invalid user Id!',
                'data'  =>  ''
                )
            );
        } 
         
        $table_cname = \Schema::getColumnListing('users');
        $except = ['id','created_at','updated_at','profile_image','modeOfreach'];
        
        foreach ($table_cname as $key => $value) {
           
           if(in_array($value, $except )){
                continue;
           } 
            if($request->get($value)){
                $user->$value = $request->get($value);
           }
        }
       
        
        if($request->get('profile_image')){ 
            $profile_image = $this->createImage($request->get('profile_image')); 
            if($profile_image==false){
                return Response::json(array(
                    'status' => 0,
                     'code' => 201,
                    'message' => 'Invalid Image format!',
                    'data'  =>  $request->all()
                    )
                );
            }
            $user->profile_image  = $profile_image;       
        }        
           

        try{
            $user->save();
            $status = 1;
            $code  = 200;
            $message ="Profile updated successfully";
        }catch(\Exception $e){
            $status = 0;
            $code  = 201;
            $message =$e->getMessage();
        }
         
        return response()->json(
                            [ 
                            "status" =>$status,
                            'code'   => $code,
                            "message"=> $message,
                            'data'=>isset($user)?$user:[]
                            ]
                        );
         
    }

    // Image upload

    public function createImage($base64)
    {
        try{
            $img  = explode(',',$base64);
            if(is_array($img) && isset($img[1])){
                $image = base64_decode($img[1]);
                $image_name= time().'.jpg';
                $path = storage_path() . "/image/" . $image_name;
              
                file_put_contents($path, $image); 
                return url::to(asset('storage/image/'.$image_name));
            }else{
                if(starts_with($base64,'http')){
                    return $base64;
                }
                return false; 
            }

            
        }catch(Exception $e){
            return false;
        }
        
    }

     // Validate user
    public function validateInput($request,$input){
        //Server side valiation 

        $validator = Validator::make($request->all(), $input);
         
        /** Return Error Message **/
        if ($validator->fails()) {
            $error_msg      =   [];
            foreach ( $validator->messages()->all() as $key => $value) {
                        array_push($error_msg, $value);     
                    }

            if($error_msg){
               return array(
                    'status' => 0,
                    'code' => 201,
                    'message' => $error_msg[0],
                    'data'  =>  $request->all()
                    );
            }

        }
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
                    'status' => false,
                    'code' => 201,
                    'message' => $error_msg[0],
                    'data' => $request->all()
                );
            }
        }

        $user_type = $request->loginType;
        switch ($user_type) {
            case 'facebookAuth':

                $credentials = [
                        'email'=>$request->get('email'),
                        'provider_id'=>$request->get('provider_id'),
                        'user_type' => 'facebookAuth'
                    ];
                    
                if (User::where($credentials)->first() ){
                   $usermodel = User::where($credentials)->first();

                    $status = true;
                    $code = 200;
                    $message = "login successfully"; 
                      
                }else{ 
                   $user = new User;
                   
                    $user->first_name    = $request->get('first_name');
                    $user->last_name     = $request->get('last_name'); 
                    $user->email         = $request->get('email'); 
                    $user->role_type     = 3;//$request->input('role_type'); ;
                    $user->user_type     = $request->get('loginType');
                    $user->provider_id   = $request->get('provider_id'); 
                    $user->password   = "";
                    
                     

                    /** Return Error Message **/
                    if (User::where(['email'=>$request->email])->first()) {
                       
                                
                        return Response::json(array(
                            'status' => false,
                            'code'=>201,
                            'message' =>'Invalid credentials',
                            'data'  =>  $request->all()
                            )
                        );
                    } 

                    $user->save() ;
                    $usermodel = $user;
 
                    $status = true;
                    $code = 200;
                    $message = "login successfully"; 
                }

                break;
            case 'googleAuth':
                
               $credentials = [
                        'email'=>$request->get('email'),
                        'provider_id'=>$request->get('provider_id'),
                        'user_type' => 'googleAuth'
                    ];

                 if (User::where($credentials)->first() ){
                   $usermodel = User::where($credentials)->first();
                   
                    $status = true;
                    $code = 200;
                    $message = "login successfully"; 
                      
                }else{   
                    $user = new User;
                   
                    $user->first_name    = $request->get('first_name');
                    $user->last_name     = $request->get('last_name'); 
                    $user->email         = $request->get('email'); 
                    $user->role_type     = 3;//$request->input('role_type'); ;
                    $user->user_type     = $request->get('loginType');
                    $user->provider_id   = $request->get('provider_id'); 
                    $user->password   = "";
                    

                    if (User::where(['email'=>$request->email])->first()) {
                       
                                
                        return Response::json(array(
                            'status' => false,
                            'code'=>201,
                            'message' =>'Invalid credentials',
                            'data'  =>  $request->all()
                            )
                        );
                    } 
                        

                    $user->save() ;
                    $usermodel =  $user;
                    $status = true;
                    $code = 200;
                    $message = "login successfully"; 
                }

                break;
            
            default:
                $credentials = [
                        'email'=>$request->get('email'),
                        'password'=>$request->get('password')
                    ];

                 $auth = Auth::attempt($credentials);


                if ($auth ){

                    $usermodel = Auth::user();

                    $status = true;
                    $code = 200;
                    $message = "login successfully";
                 

                }else{ 
                    $usermodel = null;
                    $status = false;
                    $code = 201;
                    $message = "login failed"; 
                }   
                break;
        }



        $data = [];
        if($usermodel){
            $data['first_name'] = $usermodel->first_name;
            $data['last_name'] = $usermodel->last_name;
            $data['user_email'] = $usermodel->email;
            $data['user_id'] = $usermodel->id;
            $data['mobile_number'] = $usermodel->phone;
     
        }
       
        
        return response()->json([ 
                    "status"=>$status,
                    "code"=>$code,
                    "message"=> $message ,
                    'data' => $data
                 ]);


      
        
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
                 //   'per_page' => 'required',
                //     'page' => 'required'
                ]);
        if ($validator->fails()) {
            $error_msg = [];
            foreach ($validator->messages()->all() as $key => $value) {
                array_push($error_msg, $value);
            }
            if ($error_msg) {
                return array(
                    'status' => false,
                    'code' => 201,
                    'msg' => $error_msg[0],
                    'data' => $request->all()
                );
            }
        }
      
        $editorsList  = EditorPortfolio::with('editor','softwareEditor','category')->get();
        
         // order by desc
      
        if($editorsList){
            // $editorsList =  array();
    
            // foreach($usermodel as $editors){
            //        $imageUrl = "https://edifyartist.com/storage/uploads/editorPortfolio/".$editors->image_name;
            //        $autherName = "Photoshop"; //SoftName
            //         $subTitle = "Best Kalpanic image 4ever";  // Category Name 
            //         $editorImage = "https://edifyartist.com/storage/uploads/banners/manoj_profile.png";  //Editor Image 
                    
            //         $editorsList[] = array('id' => $editors->id,'avatar' =>  $imageUrl,'post_title' => $editors->title,'total_likes' => $editors->total_likes,"auther_name"=>$autherName,"sub_title"=>$subTitle,"profile_image"=>$editorImage ); 
            //  }
            
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
