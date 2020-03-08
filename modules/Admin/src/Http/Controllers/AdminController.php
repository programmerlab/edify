<?php
namespace Modules\Admin\Http\Controllers; 

use Modules\Admin\Http\Requests\LoginRequest;
use Modules\Admin\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Dispatcher; 
use Illuminate\Contracts\Encryption\DecryptException;
use App\Http\Requests\UserRequest;
use Auth,Input,Redirect,Response,Crypt,View,Session;
use Cookie,Closure,Hash,URL,Lang,Validator;
use App\Http\Requests;
use App\Helpers\Helper as Helper;
//use Modules\Admin\Models\User; 
use Modules\Admin\Models\Category;
use Modules\Admin\Models\CategoryDashboard;
use Modules\Admin\Models\EditorTest;
use App\Admin;
use Illuminate\Http\Request;
use App\User;

/**
 * Class : AdminController
 */
class AdminController extends Controller { 
    /**
     * @var  Repository
     */ 
    /**
     * Displays all admin.
     *
     * @return \Illuminate\View\View
     */ 
    protected $guard = 'admin';
    public function __construct()
    {  
        $this->middleware('admin');  
        View::share('heading','dashboard');
        View::share('route_url','admin');
        View::share('WebsiteTitle','Edify');
    }
    /*
    * Dashboard
    **/
    public function index(Request $request) 
    { 
       // dd(Session::getId());
        $page_title = "";
        $page_action = "";
       
        $professor = User::where('role_type',1)->count();
         
        $user = User::count();
        $viewPage = "Admin";

        $users_count        =  User::count();
        $category_grp_count =  Category::where('parent_id',0)->count();
        $category_count     =  Category::where('parent_id','!=',0)->count();
        $category_dashboard_count =1; // CategoryDashboard::count();


        return view('packages::dashboard.index',compact('category_count','users_count','category_grp_count','page_title','page_action','viewPage','category_dashboard_count'));
    }

   public function profile(Request $request,Admin $users)
   {
        $users = Admin::find(Auth::guard('admin')->user()->id);
        $page_title = "Profile";
        $page_action = "My Profile";
        $viewPage = "Admin";
        $method = $request->method();
        $msg = "";
        $error_msg = [];
        if($request->method()==='POST'){
            $messages = ['password.regex' => "Your password must contain 1 lower case character 1 upper case character one number"];

            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'min:6',
                'name' => 'required', 
        ]);
        /** Return Error Message **/
        if ($validator->fails()) {

            $error_msg  =   $validator->messages()->all(); 
           return view('packages::users.admin.index',compact('error_msg','method','users','page_title','page_action','viewPage'))->with('flash_alert_notice', $msg)->withInput($request->all());
        }
            $users->name= $request->get('name');
            $users->email= $request->get('email');
            if($request->get('password')!=null){
                $users->password=    Hash::make($request->get('password'));
            }
            $users->save();
            $method = $request->method();
            $msg = "Profile details successfully updated.";
        } 
       return view('packages::users.admin.index',compact('error_msg','method','users','page_title','page_action','viewPage'))->with('flash_alert_notice', $msg)->withInput($request->all());
       
     
   }
   public function errorPage()
   {
        $page_title = "Error";
        $page_action = "Error Page";
        $viewPage = "404 Error";
        $msg = "page not found";
        return view('packages::auth.page_not_found',compact('page_title','page_action','viewPage'))->with('flash_alert_notice', $msg);

   }  

   public function ShowEditorTest()
   {
    $test_result = \DB::table('editor_test')->get();
   
    $test_result->transform(function($item,$key){
        $editor_data = User::where('id',$item->eid)->get();
        $item->fname = $editor_data[0]->first_name;
        $item->email = $editor_data[0]->email;
        return $item;
    });
    // print_r($test_result); exit;
        $page_title = "Editor Test";
        $page_action = "Editor Test";
        $viewPage = "Editor Test";
       return view('packages::EditorTest.ShowEditorTest',compact('test_result','page_title','page_action','viewPage'));
   }

   public function changeteststatus(Request $request)
   {
     $id = $request->input('id');
     $flag = $request->input('flag');
     $update = \DB::table('editor_test')->where('eid', $id)->update([$flag => 'approved']);
     return redirect()->back();
   }

   public function ChangeSKillTestStatus(Request $request)
   {
       $eid = $request->input('eid');
       $status = $request->input('status');
       $col_name = $request->input('col_name');

       if($status == 0)
       {
         $update = \DB::table('editor_test')->where('eid', $eid)->update([$col_name => 1]);
         return 1;
       }
       else{
         $update = \DB::table('editor_test')->where('eid', $eid)->update([$col_name => 0]);
         return 0;
       
        }
   }

   public function testImages(Request $request)
   {
        if ($request->hasfile('myfile')){
            $id = $request->input('hidden_id');
            $photo = $request->file('myfile');
            $destinationPath = storage_path('uploads/editor_test_imgs');
            $photo->move($destinationPath, time().$photo->getClientOriginalName());
            $photo_name = time().$photo->getClientOriginalName();
            $update_img = \DB::table('editor_test_images')->where('id',$id)->update(['images' => $photo_name]);
            return redirect()->back();
        }
        else{
            $page_title = "Editor Test";
            $page_action = "Editor Test";
            $viewPage = "Editor Test";
            $test_images = \DB::table('editor_test_images')->get();
        return view('packages::EditorTest.EditorTestImages',compact('test_images','page_title','page_action','viewPage'));
        }
    }

}
