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

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.editordashboard');
    }

    public function MyAccount()
    {
        return view('dashboard.myaccount');
    }

    public function MyStories()
    {
        return view('dashboard.stories');
    }

    public function PostInfo()
    {
        return view('dashboard.postinfo');
    }

    public function PostUpload()
    {
        return view('dashboard.postupload');
    }

    public function Posts()
    {
        return view('dashboard.posts');
    }

    public function MyOrders()
    {
        return view('dashboard.myorders');
    }

    public function HowItWorks()
    {
        return view('dashboard.hiw');
    }

    public function Faq()
    {
        return view('dashboard.faq');
    }

    public function Tnc()
    {
        return view('dashboard.tnc');
    }
}
