<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Auth,Input,Redirect,Response,Crypt,View,Session;
use Cookie,Closure,Hash,URL,Lang,Validator;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use Modules\Admin\Models\EditorTest;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use App\Helpers\Helper;

class FrontEndController extends Controller
{
    public function __construct() { 
        $pages = \DB::table('pages')->get(['title','slug']);
        View::share('static_page',$pages);
        $aid = Auth::user()->id??null;
        $editor_aproved = EditorTest::where('eid',$aid)
                ->where('img1_status',1)
                ->where('img2_status',1)
                ->where('img3_status',1)
                ->first(); 
        View::share('editor_aproved',$editor_aproved);
    }

    public function index()
    {
        if(Auth::check()){        
          $check_eid = EditorTest::where('eid',Auth::user()->id)->first();
                if ($check_eid == null) {
                    return redirect(URL::to('editortest'));
                }else{
                    return redirect(URL::to('editordashboard'));
                }
        } 
        return view('pages.home');
    }

    public function page(Request $request, $page = null)
    {
        $pages = \DB::table('pages')->where('slug', $page)->first();
        $title = isset($pages->title)?$pages->title:'Page Not Found';

        return view('dashboard.page', compact('title', 'pages'));
    }

    public function signup(Request $request)
    { 

        $request['password'] = Hash::make($request['password']);

        $validator = Validator::make($request->all(), [
            'first_name'=>'required',
            'last_name'=>'required',
            'phone'=>'required',
            'email' => 'required|email|unique:users',
            'password'=>'required',
        ]);  
        // Return Error Message
        if ($validator->fails()) {
                    $error_msg  =   []; 
                    $tag = '<ul style="list-style:square">';

            foreach ( $validator->messages()->all() as $key => $value) {
                        array_push($error_msg, $value); 
                        $tag = $tag ."<li>".$value."</li>"; 
                    } 
            
            Session::put('signup_msg', $tag.'</ul>'); 
            return Redirect::back()->withInput()->withErrors($validator);
        }
        User::create($request->all())->id; 
        Session::put('signup_msg', 'Verify your email to get start!'); 

        $link = '<a href='.url("emailVerification").'>Click here to verify</a>';
        $email_content = [
                'receipent_email'=> $request->input('email'),
                'subject'=> 'Verify your account',
                'receipent_name'=>$request->input('first_name'),
                'sender_name'=>'Edify',
                'data' => 'Thank you for registration kindly Verify you email.'.$link
            ];
        
        $helper = new Helper;
        $helper->sendMail($email_content, 'testmail');

        return redirect(URL::to('/')); 
    }

    public function logout(Request $request){

        Auth::logout();
        $request->session()->forget('login_status');

        return redirect(URL::to('/'));
    }

    public function editortest(){
        $test_imgs = \DB::table('editor_test_images')->get();
      
        $path = "storage/uploads/editor_test_imgs"; 

        return view('pages.editortest',  compact('test_imgs','path'));
    }

    public function login(Request $request)
    {
        if(Auth::check()){
             
          $check_eid = EditorTest::where('eid',Auth::user()->id)->first();
                if ($check_eid == null) {
                    return redirect(URL::to('editortest'));

                }
        }


        $check_user = User::where('email',$request['email'])->first();
        $credential = [
                "email" => $request->email,
                "password" => $request->password
            ];



        if(Auth::attempt($credential))
        {
            Session::put('login_status',true);
            $cc = Hash::check($request['password'], $check_user->password);
            if(!$cc){
                Session::put('message', 'Login Fail, pls check Password');
                return redirect('/');
                // return response()->json(['success'=>false, 'message' => 'Login Fail, pls check password']);
            }else{
                Session::put('editor_id', $check_user->id);
                $check_eid = EditorTest::where('eid',$check_user->id)->first();
                    if ($check_eid == null) {
                        $test_imgs = \DB::table('editor_test_images')->get();
                        return redirect(URL::to('editortest'));
                    } else {
                        if($check_eid['img1_status'] == 1 && $check_eid['img2_status'] == 1 && $check_eid['img3_status'] == 1)
                        {
                            Session::put('name', $check_user->first_name);                        
                            Session::put('email', $check_user->email);                        
                            return redirect('editordashboard');
                        }
                        else{
                            Session::put('test_status_msg', 'Please wait !! Your test result is under process.');
                            return redirect('/');
                        }
                    }
            }
        }
        else{
            Session::put('message', 'Login Fail, please check Email id');
                return redirect('/');
            return response()->json(['success'=>false, 'message' => 'Login Fail, pls check Email id']);
        }
    }
    

    public function validation($request)
    {
        return $this->validate($request,[
            'first_name'=>'required',
            'last_name'=>'required',
            'phone'=>'required',
            'email'=>'required|email',
            'password'=>'required',
         ]);
    }

    public function UploadTestImages(Request $request)
    {
        $eid = Session::get('editor_id');
        if($request->hasFile('img1'))
        {
            $img1 = $request->file('img1');
            $destinationPath = storage_path('uploads/editor_test_imgs');
            $img1->move($destinationPath, time().$img1->getClientOriginalName());
            $img1_name = time().$img1->getClientOriginalName();

        }else{
             $request->validate([
                'img1' => 'required' 
            ]);
        }
        if($request->hasFile('img2'))
        {
            $img2 = $request->file('img2');
            $destinationPath = storage_path('uploads/editor_test_imgs');
            $img2->move($destinationPath, time().$img2->getClientOriginalName());
            $img2_name = time().$img2->getClientOriginalName();

        }
        else
        {
             $request->validate([
                'img2' => 'required' 
            ]);
        }
        if($request->hasFile('img3'))
        {
            $img3 = $request->file('img3');
            $destinationPath = storage_path('uploads/editor_test_imgs');
            $img3->move($destinationPath, time().$img3->getClientOriginalName());
            $img3_name = time().$img3->getClientOriginalName();

        }else{
            $request->validate([
                'img3' => 'required' 
            ]);
        } 



        $data = array('eid'=>$eid, 'img1' => $img1_name, 'img2' => $img2_name, 'img3'=>$img3_name, 'img1_status'=>0, 'img2_status'=>0, 'img3_status'=>0 , 'insta_id'=>$request->get('insta_id') , 'fb_id'=>$request->get('fb_id') , 'other_id'=>$request->get('other_id'));
        $insert = EditorTest::insert($data);
        
        Session::put('test_status_msg', 'Thank you!! Your test has been submitted. please wait for the approval !!');
        return redirect('/');

        }

        public function ForgotPassword(Request $request)
        {
            $email = $request['forgot-email'];
            $check_user = User::where('email',$email)->first();

            $helper = new Helper; 

            if($check_user)
            {    
                $password = strtoupper($helper->generateRandomString(6));
                $user = User::find($check_user->id);
                $user->password = Hash::make($password);
                $user->save();

                $email_content = [
                    'receipent_email'=> $user->email,
                    'subject'=> 'Temporary password',
                    'receipent_name'=>$user->first_name,
                    'sender_name'=>'Edify',
                    'data' => 'Your Temporary Password is: <b>'.$password.'</b>'
                ];
                
                Session::put('message', 'Temporary password sent to your register email id. Kindly check your email.');
                
                $helper->sendMail($email_content, 'testmail');

                return redirect('/');
            }
            else{
                Session::put('message', 'Email Does not exist !! Please check and try again later');
                return redirect('/');
            }
        }
}
