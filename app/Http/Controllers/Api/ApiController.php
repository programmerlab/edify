<?php

namespace App\Http\Controllers\Api;

use Modules\Admin\Models\EditorPortfolio;
use Modules\Admin\Models\EditorPosts;
use Modules\Admin\Models\SoftwareEditor;
use Modules\Admin\Models\Category;
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
        $input['role_type']     = $request->input('role_type'); 
        $input['user_type']     = $request->input('user_type');
        $input['provider_id']   = $request->input('provider_id'); 
         $input['profile_image']   = $request->input('profile_image'); 
        
        

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

        $subject = "Welcome to edify!";
        $link = '<a href='.url("emailVerification").'>Click here to verify</a>';
        $email_content = [
                'receipent_email'=> $request->input('email'),
                'subject'=> $subject,
                'receipent_name'=> $request->input('first_name'),
                'sender_name'=>'EdifyArtist',
                'data' => 'Verify your email address to get started.'.$link
            ];
        
        $helper = new Helper;
        $helper->sendMail($email_content, 'testmail');

        $notification = new Notification;
        $notification->addNotification('user_register',$user->id,$user->id,'User register','');
       
        return response()->json(
                            [ 
                                "status"=>true,
                                "code"=>200,
                                "message"=>"Thank you for registration",
                                'data'=>$user
                            ]
                        );
    }


//     public function updateProfile(Request $request,$userId)
//     {      
// 
//         $user = User::find($userId); 
// 
//         if((User::find($userId))==null)
//         {
//             return Response::json(array(
//                 'status' => 0,
//                 'code' => 201,
//                 'message' => 'Invalid user Id!',
//                 'data'  =>  ''
//                 )
//             );
//         } 
//          
//         $table_cname = \Schema::getColumnListing('users');
//         $except = ['id','created_at','updated_at','profile_image','modeOfreach'];
//         
//         foreach ($table_cname as $key => $value) {
//            
//            if(in_array($value, $except )){
//                 continue;
//            } 
//             if($request->get($value)){
//                 $user->$value = $request->get($value);
//            }
//         }
//        
//         
//         if($request->get('profile_image')){ 
//             $profile_image = $this->createImage($request->get('profile_image')); 
//             if($profile_image==false){
//                 return Response::json(array(
//                     'status' => 0,
//                      'code' => 201,
//                     'message' => 'Invalid Image format!',
//                     'data'  =>  $request->all()
//                     )
//                 );
//             }
//             $user->profile_image  = $profile_image;       
//         }        
//            
// 
//         try{
//             $user->save();
//             $status = 1;
//             $code  = 200;
//             $message ="Profile updated successfully";
//         }catch(\Exception $e){
//             $status = 0;
//             $code  = 201;
//             $message =$e->getMessage();
//         }
//          
//         return response()->json(
//                             [ 
//                             "status" =>$status,
//                             'code'   => $code,
//                             "message"=> $message,
//                             'data'=>isset($user)?$user:[]
//                             ]
//                         );
//          
//     }

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

        $input = $request->all();
    //    print_r($input);exit;
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        // $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['first_name'] =  $user->name;

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
      
      
       //echo "Email:".$request->email;
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
                        'email'=>$request->get('email')
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
            $data['profile_image'] = $usermodel->profile_image;
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
                    'status' => false,
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
            
            return response()->json(["status" => true, "code" => 200, "msg" => "Successfully logged in.", 'data' => $editorsList]);
        }else{   
            return response()->json(["status" => false, "code" => 401, "msg" => "User doesn't exsist.", 'user_data' => $input]);  
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
                    'status' => false,
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
            
            return response()->json(["status" => true, "code" => 200, "msg" => "Successfully logged in.", 'data' => $editorsList]);
        }else{   
            return response()->json(["status" => false, "code" => 401, "msg" => "User doesn't exsist.", 'user_data' => $input]);  
        }
    }


    public function getAllPosts(Request $request)
    {
        $page_number    =   $request->get('page_num');
     
        if($page_number){
            $page_num   =   ($request->get('page_num'))?$request->get('page_num'):1;
            $page_size  =   ($request->get('page_size'))?$request->get('page_size'):50; 
        }else{
            $page_num = 1;
            $page_size = 50;
        }
  
        $input = $request->all();
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
        
        $allEditors = array();
         $usermodel  = \DB::table('users')
                            ->where('role_type' , 5)
                            ->get();
         
        if($usermodel){
             foreach($usermodel as $editors){
                     $stsl  = \DB::table('stories')
                            ->where('eid' , $editors->id)
                            ->get();
                      if(sizeof($stsl)>0){
                             $listofstories = array();
                          foreach($stsl as $strsObj){
                                        $listofstories[] = "https://edifyartist.com/storage/uploads/editor_stories_imgs/".$strsObj->story_img; 
                              }
                              
                           $allEditors[] = array('id' => $editors->id,'profile_image' => $editors->profile_image,'first_name' => $editors->first_name,'last_name' => $editors->last_name,'stories_list'=>$listofstories ); 
                      }      
             }
        }
        
        $allBanners = array();
        
         $bannerModel  = \DB::table('banners')
                            ->where('status' , 1)
                            ->get();
         
       $bannersList=  array();
        if($bannerModel){
             foreach($bannerModel as $ban){
                    $bannersList[] = array('id' => $ban->id,'avatar' => $ban->photo,'banner_title' => $ban->title); 
             }
        }

       if($page_number>1){
                  $offset = $page_size*($page_num);
        }else{
              $offset = 0;
        }  
// 
//         $allPosts =  $editorsList->orderBy('created_at', 'desc')
//                         ->skip($offset)
//                         ->take($page_size)
//                         ->get()
//                         ->toArray();

         // order by desc
         
          //AllPosts
        $allPosts = array();
        
         $allPostsModel  = \DB::table('editor_post')
                            ->orderBy('created_at' , 'desc')
                            ->skip($offset)
                             ->take($page_size)
                            ->get();
                                   
        if($allPostsModel){
             $settingsValue  = \DB::table('settings')
                            ->where('field_key' , 'service_charge')
                            ->first();
                            
             foreach($allPostsModel as $postModels){
                    
                     $likeTableCnt  = \DB::table('portfolio_likes_count')
                           ->where('portfolio_id' ,$postModels->id)
                           ->where('user_id' ,$request->user_id)
                            ->get();
                            
                        $count = count($likeTableCnt );
                        $likes = false;
                        if( $count>0){
                             $likes = true;
                        }   
                            
                    $editorInfoModel  = \DB::table('users')
                            ->where('id' , $postModels ->eid)
                            ->first();
                    
                    $allPosts[] = array('id' => $postModels->id,
                                 'image_name_after' => "https://edifyartist.com/storage/uploads/editor_test_imgs/".$postModels ->after_img,
                                 'image_name_before' => "https://edifyartist.com/storage/uploads/editor_test_imgs/".$postModels-> before_img,
                                 'editor_id' => $postModels ->eid,
                                 'making_charges' => $settingsValue ->field_value,
                                 'isliked_by_user' => $likes,
                                 'editor_details'=>$editorInfoModel); 
             }
        }
      
        if($allPosts){ 
            
            return response()->json(["status" => true, "code" => 200, "message" => "record found",'all_editors' => $allEditors,'all_banners' => $bannersList, 'all_post' => $allPosts]);
        }else{   
            return response()->json(["status" => false, "code" => 404, "message" => "Record not found", 'all_editors' => $allEditors,'all_banners' => $allBanners,'all_post' => $input]);  
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
                    'status' => false,
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
            
            return response()->json(["status" => true, "code" => 200, "msg" => "Successfully logged in.", 'data' => $editorsList]);
        }else{   
            return response()->json(["status" => false, "code" => 401, "msg" => "User doesn't exsist.", 'user_data' => $input]);  
        }
    }


  

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

    public function getAllMyLikes(Request $request){

         $validator = Validator::make($request->all(), [
                    'user_id' => 'required' 
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


        $portfolio_id = \DB::table('portfolio_likes_count')
                    ->where('user_id',$request->user_id) 
                    ->pluck('portfolio_id');
    
        $portfolio = [];
        if(count($portfolio_id)){ 
                  $portfolioModel  = \DB::table('editor_post')
                                             ->whereIn('id',$portfolio_id)
                                             -> get();
                          
                    $settingsValue  = \DB::table('settings')
                            ->where('field_key' , 'service_charge')
                            ->first();
                                  
                   foreach($portfolioModel as $portfolioList ){
                         
                          $editorInfoModel  = \DB::table('users')
                            ->where('id' , $portfolioList->eid)
                            ->first();
                            
                           $portfolio[] = array('id' => $portfolioList->id,
                                 'image_name_after' => "https://edifyartist.com/storage/uploads/editor_test_imgs/".$portfolioList ->after_img,
                                 'image_name_before' => "https://edifyartist.com/storage/uploads/editor_test_imgs/".$portfolioList-> before_img,
                                  'making_charges' => $settingsValue ->field_value,
                                 'likes' => true,
                                 'editor_details'=>$editorInfoModel
                              ); 
                   }       
        }
        
        return response()
            ->json([
                'status' => true,
                'code' => 200,
                'message' => 'My likes portfolio',
                'all_post' => $portfolio
            ]);

    }

    public function postLikes(Request $request){

        //print_r ($input);
        $validator = Validator::make($request->all(), [
                    'user_id' => 'required',
                    'portfolio_id' => 'required',
                    'is_liked_byuser' => 'required'
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

        if(!User::find($request->user_id)){
           return array(
                    'status' => false,
                    'code' => 201,
                    'message' => 'Invalid user ID',
                    'data' => $request->all()
                ); 
        }
        if(!EditorPosts::find($request->portfolio_id)){
                return array(
                    'status' => false,
                    'code' => 201,
                    'message' => 'Invalid portfolio id',
                    'data' => $request->all()
                );
        }

        \DB::beginTransaction();

        
        $data['user_id'] = $request->user_id;
        $data['portfolio_id'] = $request->portfolio_id;

       // $portfolio = EditorPosts::find($request->portfolio_id);
   
    //print_r( $portfolio);
     //echo "is liked by users".$request->is_liked_byuser;
     
          $portfolioliske = \DB::table('portfolio_likes_count')
                          ->where('user_id',$request->user_id)
                           ->where('portfolio_id',$request->portfolio_id)
                          -> get();
            
            $count =  count($portfolioliske);        
          if($count >0){
                   \DB::table('portfolio_likes_count')->where($data)->delete();
          } else {               
            \DB::table('portfolio_likes_count')->insert($data);
        }
        

        \DB::commit();
         return array(
                    'status' => true,
                    'code' => 200,
                    'message' => 'Likes updated'
                );


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
    
    


     public function getAllCategories(Request $request)
    {
        $usermodel  = \DB::table('categories')
                            ->where('status' , 1)
                            ->get();
        $categoryList =  array();
        if($usermodel){
             $settingsValue  = \DB::table('settings')
                            ->where('field_key' , 'service_charge')
                            ->first();
             foreach($usermodel as $categories){
                   $editorsPostList =  array();
                    $etpostlst = \DB::table('editor_profiles') ->where('category_name' , $categories->id)->get();
                    if($etpostlst){
                       
                         $editorInfoModel  = \DB::table('users')
                            ->where('id' , '267')
                            ->first();
                    
                        

                          foreach($etpostlst as $editorPosts){
                                 $image_url = "https://edifyartist.com/storage/uploads/editorPortfolio/".$editorPosts->image_name;
                                 $editorsPostList[] = array('id' => $editorPosts->id,
                                 'image_name_after' =>$image_url,
                                 'image_name_before' => $image_url,
                                 'editor_id' => '267',
                                  'making_charges' => $settingsValue ->field_value,
                                 'isliked_by_user' => false,
                                 'editor_details'=>$editorInfoModel); 
                           }
                        
                        
                    }
                 
                 $categoryList[] = array('id' => $categories->id,'category_name' => $categories->category_name,'editors_post' =>$editorsPostList); 
                 
                 
                 
                 
             }
            return response()->json(["status" => true, "code" => 200, "msg" => "Successfully logged in.", 'categories_list' => $categoryList]);
        }
      
        return response()
        ->json([
            'status' => false
        ]);
    }


  public function uploadImages(Request $request)
    {
    	if ($request->file('imagefile')) {        

            $photo = $request->file('imagefile');
            $destinationPath = storage_path('uploads');
            $photo->move($destinationPath, time().$photo->getClientOriginalName());
            $photo_name = time().$photo->getClientOriginalName();
            
            $data = [
                    "success"=>"1", 
                    "msg"=>"Image uplaoded successfully",
                    "imageurl"=>url('storage/uploads/'. $photo_name)
                ];
                
        }  
        else
        {
            $data=array("success"=>"0", "msg"=>"Image Type Not Right");
        }
        return $data;
	}


// Place Orders 
    public function place_order(Request $request){
        
        $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'deposit_amount' => 'required',
                'transaction_id' => 'required', 
                'payment_mode' => 'required',
                'payment_status' => 'required'
            ]); 
        
       
        // Return Error Message
        if ($validator->fails()) {
                    $error_msg  =   [];
            foreach ( $validator->messages()->all() as $key => $value) {
                        array_push($error_msg, $value);     
                    }
                            
            return Response::json(array(
                'code' => 201,
                'status' => false,
                'message' => $error_msg
                )
            );
        }

        $orderId = mt_rand(100000000, 999999999);
        $data['user_id'] = $request->user_id;
        $data['editor_id'] = $request->editor_id;
        $data['editor_status'] = 1; //1="pending" , 2="confirmed", 3="completed" , 4= "Approved by Edify" , 5 =. Accepted by customer""
        $data['customer_original_image'] = $request->original_customer_image;
        $data['customer_reference_image'] = $request->original_customer_ref_image;
        $data['editor_after_work_image'] = "";
        $data['payment_mode'] = $request->payment_mode;
        $data['status'] = 1;
        $data['total_price'] = $request->deposit_amount;
        $data['discount_price'] = $request->deposit_amount;
        $data['order_id'] = $orderId;
        $data['order_details'] = $request->customer_notes; 


        $user = User::find($request->user_id);
        $editor = User::find($request->editor_id);

        $email_content1 = [
                'receipent_email'=> $user->email,
                'subject'=> 'Order Placed successfully',
                'receipent_name'=>$user->first_name,
                'sender_name'=>'EdifyArtist',
                'data' => 'Thank you!. You have successfully placed the order. You have made payment of '.$request->deposit_amount.' and your orderID is '.$orderId
            ];
        $email_content2 = [
                'receipent_email'=> $editor->email,
                'subject'=> 'New Order Recieved',
                'receipent_name'=>$editor->first_name,
                'sender_name'=>'EdifyArtist',
                'data' => 'Congratulation!. You have new order.'
            ];
        
        $helper = new Helper;
        $helper->sendMail($email_content1, 'testmail');
        $helper->sendMail($email_content2, 'testmail');
          
        \DB::table('orders')->insert($data);
      return response()->json(
                        [ 
                            "status"=>true,
                            "code"=>200,
                            "message" => "Transaction success, will get in touch with you"
                        ]
                    );
       
  }

     public function getMyOrders(Request $request)
    {
      
       // echo "Email:".$request->email;
        $input = $request->all();
        //print_r ($input);
        $validator = Validator::make($request->all(), [
                    'user_id' => 'required'
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
                    'user_data' => $request->all()
                );
            }
        }
      
             $usermodel  = \DB::table('orders')
                            ->where('user_id' , $request->user_id)
                            ->get();
         
      $editorsList =  array();
        if($usermodel){
            
             foreach($usermodel as $editors){
                   $imageUrl = $editors->customer_original_image;
                   $totalPrice = $editors->total_price; 
                   $orderId = $editors->order_id;
                   $editorStatus = $editors->editor_status; 
                   $orderDetails = $editors->order_details; 
                   $createdDate = $editors->created_at; 
                    $udpatedDate = $editors->updated_at; 
                    $editorsList[] = array(
                                      'id' => $orderId,
                                      'avatar' =>  $imageUrl,
                                      'total_price' => $totalPrice,
                                     'order_status' => (int)$editorStatus,
                                     'orderDetails'=>$orderDetails,
                                     'created_at'=>$createdDate,
                                    'udpated_at'=>$udpatedDate); 
             }
            
            return response()->json(["status" => true, "code" => 200, "msg" => "Successfully logged in.", 'data' => $editorsList]);
        }else{   
            return response()->json(["status" => false, "code" => 401, "msg" => "User doesn't exsist.", 'data' => $editorsList]);  
        }
    }

     

  //ALL Editor Post
  
   public function getEditorPosts(Request $request){

         $validator = Validator::make($request->all(), [
                    'editor_id' => 'required' 
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

         $allPosts = array();
         $allPostsModel  = \DB::table('editor_post')
                            ->where('eid',$request->editor_id)
                            ->orderBy('created_at' , 'desc')
                            ->get();
    
        if($allPostsModel){
             foreach($allPostsModel as $postModels){
                 $editorInfoModel  = \DB::table('users')
                            ->where('id' , $postModels ->eid)
                            ->first();
                    $likes = 0;
                    $allPosts[] = array('id' => $postModels->id,
                                 'image_name_after' => "https://edifyartist.com/storage/uploads/editor_test_imgs/".$postModels ->after_img,
                                 'image_name_before' => "https://edifyartist.com/storage/uploads/editor_test_imgs/".$postModels-> before_img,
                                 'likes' => $likes,
                                 'editor_details'=>$editorInfoModel
                              ); 
             }
       }
        if($allPosts){ 
            return response()->json(["status" => true, "code" => 200, "message" => "record found", 'all_post' => $allPosts]);
        }else{   
            return response()->json(["status" => false, "code" => 404, "message" => "Record not found", 'all_post' => $allPosts]);  
        }
       
    }
   
   
     //Update profile
      public function updateProfile(Request $request){

         $validator = Validator::make($request->all(), [
                    'user_id' => 'required' 
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
        
        //$data['user_id'] = $request->user_id;
        $data['profile_image'] = $request->profile_image;
        $data['first_name'] = $request->first_name;
        $data['last_name'] = $request->last_name;
        $data['phone'] = $request->phoneNumber;
    
       \DB::table('users')
              ->where('id',$request->user_id)
             ->update(
                             [
                                'profile_image'=>$request->profile_image,
                                'first_name'=>$request->first_name,
                                'last_name'=>$request->last_name,
                                'phone'=>$request->phoneNumber
                              ]
                          );
        
           return array(
                    'status' => true,
                    'code' => 200,
                    'message' => "Profile updated successfully"  
                    );
    }

    public function getPageUrl(){

        $pages = \DB::table('pages')
                ->orderBy('title','asc')
                ->get(['title','slug']);
        $data = null;
        foreach ($pages as $key => $page) {
                     
                     $data[] = [
                        'page_name' => $page->title,
                        'page_url' => url('page/'.$page->slug),
                     ] ;
                } 
           return array(
                    'status' => true,
                    'code' => 200,
                    'message' => "Profile updated successfully"  ,
                    'data' => $data
                    );              
    }
}
