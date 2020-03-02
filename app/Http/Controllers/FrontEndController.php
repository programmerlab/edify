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
        return redirect('http://localhost/edify-master/');
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
                return redirect('http://localhost/edify-master/');
                // return response()->json(['success'=>false, 'message' => 'Login Fail, pls check password']);
            }else{
                $check_eid = EditorTest::where('eid',$check_user->id)->first();
                    if ($check_eid == null) {
                        $test_imgs = \DB::table('editor_test_images')->get();
                        return view('pages.editortest',['test_imgs'=>$test_imgs]);
                    } else {
                        return view('pages.editordashboard');
                    }
            }
        }
        else{
            Session::put('message', 'Login Fail, pls check Email id');
                return redirect('http://localhost/edify-master/');
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
}
