<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
