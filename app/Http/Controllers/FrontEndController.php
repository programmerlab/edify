<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Auth,Input,Redirect,Response,Crypt,View,Session;
use Cookie,Closure,Hash,URL,Lang,Validator;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;


class FrontEndController extends Controller
{
    public function index()
    {
        return view('pages.home');
    }

    public function signup(Request $request)
    {
        // return $request->all();
        User::create($request->all());
        return view('pages.home',['msg' =>"success Thank you for registration. Login to Continue"]);
    }

    public function login()
    {
        echo "aaaaaa"; exit;
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
