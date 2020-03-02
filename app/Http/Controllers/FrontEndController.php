<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Auth,Input,Redirect,Response,Crypt,View,Session;
use Cookie,Closure,Hash,URL,Lang,Validator;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use Modules\Admin\Models\EditorTest;


class FrontEndController extends Controller
{
    public function index()
    {
        return view('pages.home');
    }

    public function signup(Request $request)
    {
        $request['password'] = Hash::make($request['password']);
        User::create($request->all())->id;
        Session::put('signup_msg', 'Thank you for registration. Login to Continue');
        return redirect(URL::to('/'));
        // return view('pages.home',['msg' =>"success Thank you for registration. Login to Continue"]);
    }

    public function login(Request $request)
    {
        $check_user = User::where('email',$request['email'])->first();
        if($check_user)
        {
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
                        return view('pages.editortest',['test_imgs'=>$test_imgs]);
                    } else {
                        if($check_eid['img1_status'] == 'approved' && $check_eid['img2_status'] == 'approved' && $check_eid['img3_status'] == 'approved')
                        {
                            return view('pages.editordashboard');
                        }
                        else{
                            Session::put('test_status_msg', 'Please wait !! Your test result is under process.');
                            return redirect('/');
                        }
                    }
            }
        }
        else{
            Session::put('message', 'Login Fail, pls check Email id');
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

        }
        if($request->hasFile('img2'))
        {
            $img2 = $request->file('img2');
            $destinationPath = storage_path('uploads/editor_test_imgs');
            $img2->move($destinationPath, time().$img2->getClientOriginalName());
            $img2_name = time().$img2->getClientOriginalName();

        }
        if($request->hasFile('img3'))
        {
            $img3 = $request->file('img3');
            $destinationPath = storage_path('uploads/editor_test_imgs');
            $img3->move($destinationPath, time().$img3->getClientOriginalName());
            $img3_name = time().$img3->getClientOriginalName();

        }
        $data = array('eid'=>$eid, 'img1' => $img1_name, 'img2' => $img2_name, 'img3'=>$img3_name, 'img1_status'=>'pending', 'img2_status'=>'pending', 'img3_status'=>'pending' , 'insta_id'=>$request->get('insta_id') , 'fb_id'=>$request->get('fb_id') , 'other_id'=>$request->get('other_id'));
        $insert = EditorTest::insert($data);
        
        Session::put('test_status_msg', 'Thank you!! Your test has been submitted. please wait for the approval !!');
        return redirect('/');

        }
}