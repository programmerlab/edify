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
        $eid = Session::get('editor_id');
        $acc_details = User::where('id', $eid)->first();
        return view('dashboard.myaccount', compact('acc_details'));
    }

    public function MyStories()
    {
        $eid = Session::get('editor_id');
        $stories = \DB::table('stories')->where('eid', $eid)->get();
        return view('dashboard.stories', compact('stories'));
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
        $eid = Session::get('editor_id');
        $editor_posts = \DB::table('editor_post')->where('eid', $eid)->get();

        return view('dashboard.posts', compact('editor_posts'));
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

    public function UpdateEditorInfo(Request $request)
    {
        $data = array('first_name'=>$request['first_name'],'last_name'=>$request['last_name'],'email'=>$request['email_address'],'phone'=>$request['mob']);
        $update = User::where('id',Session::get('editor_id'))->update($data);
        if($update)
        {
            Session::put('update_msg','Details Update Succesffuly');
            return redirect('myaccount');
        }
    }

    public function UploadPost(Request $request)
    {
        // return $request->all();
        if($request->hasFile('postbefore'))
        {
            $img1 = $request->file('postbefore');
            $destinationPath = storage_path('uploads/editor_test_imgs');
            $img1->move($destinationPath, time().$img1->getClientOriginalName());
            $img1_name = time().$img1->getClientOriginalName();

        }
        if($request->hasFile('postafter'))
        {
            $img2 = $request->file('postafter');
            $destinationPath = storage_path('uploads/editor_test_imgs');
            $img2->move($destinationPath, time().$img2->getClientOriginalName());
            $img2_name = time().$img2->getClientOriginalName();

        }
        $data = array('eid'=>Session::get('editor_id'),'before_img'=>$img1_name,'after_img'=>$img2_name,'software'=>$request['sw'],'comment'=>$request['comment']);

        $insert = \DB::table('editor_post')->insert($data);
        if($insert)
        {
            Session::put('postuploadmsg','Data Inserted Completly');
            return redirect('postupload');
        }

    }

    public function UploadStories(Request $request)
    {
        if($request->hasFile('storyUpload'))
        {
            $img1 = $request->file('storyUpload');
            $destinationPath = storage_path('uploads/editor_stories_imgs');
            $img1->move($destinationPath, time().$img1->getClientOriginalName());
            $img_name = time().$img1->getClientOriginalName();

        }
        $data = array('eid'=>Session::get('editor_id'),'story_img'=>$img_name);
        $insert = \DB::table('stories')->insert($data);

        if($insert)
        {
            Session::put('storyuploadmsg','Story Uploaded Completly');
            return redirect('mystories');
        }
    }

    public function logout(Request $request)
    {
        Session::flush();
        return redirect('/');
    }
}
