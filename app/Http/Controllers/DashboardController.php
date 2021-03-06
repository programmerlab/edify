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
use App\Helpers\FCMHelper;
use PHPMailerAutoload;
use PHPMailer;

class DashboardController extends Controller
{
    
    public function __construct() {
        $this->middleware('auth'); 

        $pages = \DB::table('pages')->get(['title','slug']);
        View::share('static_page',$pages);

        $eid = (Auth::user()->id)??null;

        $editor_aproved = EditorTest::where('eid',$eid)
                ->where('img1_status',1)
                ->where('img2_status',1)
                ->where('img3_status',1)
                ->first(); 
        View::share('editor_aproved',$editor_aproved);

    }

    public function downloadFile(Request $request){

        $path  =$request->download;
        return Response::download($path);
    }

    public function index()
    {
         if(Auth::check()){ 
          $check_status = EditorTest::where('eid',Auth::user()->id)->first();           

            if ($check_status == null) {
                return redirect(URL::to('editortest'));

            } 
         return view('dashboard.editordashboard', compact('check_status'));    
        } else{
             return Redirect::to(url('/')); 
        } 
    }

    public function MyAccount()
    {
        $eid = Session::get('editor_id');
        $acc_details = User::where('id', $eid)->first();
        $profile_image =  $acc_details->profile_image??null;

        $bankAccount = \DB::table('bank_accounts')->where('user_id', $eid)->first();
        
        return view('dashboard.myaccount', compact('acc_details','profile_image','bankAccount'));
    }

    public function bankAccount(Request $request)
    {
        
        $eid = Auth::user()->id;
        $acc_details = User::where('id', $eid)->first();
        $profile_image =  $acc_details->profile_image??null;

        $arr = $request->only('account_name','bank_name','account_number','ifsc_code','bank_branch'); 

        \DB::table('bank_accounts')->updateOrInsert([
            'user_id' => $eid 
        ],$arr); 
        return redirect('myaccount');
    }


    public function MyStories()
    {
        $eid = Session::get('editor_id');
        $stories = \DB::table('stories')->where('eid', $eid)->get();
        return view('dashboard.stories', compact('stories'));
    }

    public function uploadDocument()
    {
        $eid = Auth::user()->id;
        $documents = \DB::table('documents')->where('user_id', $eid)->get();
        return view('dashboard.upload_document', compact('documents'));
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
    
    
    public function DocumentDelete($id=null){  

         \DB::table('documents')
                        ->where('id', $id)
                        ->delete();
       
       return redirect('upload-document')->with('flash_alert_notice', 'Upload-document Deleted successfully');
    }

    public function storyDelete($id=null){  

         \DB::table('stories')
                        ->where('id', $id)
                        ->delete();
       
       return redirect('mystories')->with('flash_alert_notice', 'Post Deleted successfully');
    }

    public function PostDelete($id=null){  
         \DB::table('editor_post')
                        ->where('id', $id)
                        ->delete();       
       return redirect('posts')->with('flash_alert_notice', 'Post Deleted successfully');
    }

    public function uploadEditedImage(Request $request){
        
        if ($request->file('editedImage')) {
            $photo = $request->file('editedImage');
            $destinationPath = storage_path('uploads/editedImage/');
            $photo_name = time().'.'.$photo->getClientOriginalExtension();
            $photo->move($destinationPath, $photo_name); 
            $request->merge(['editor_after_work_image'=>$photo_name]);  
            $data['editor_after_work_image']  = url::to(asset('storage/uploads/editedImage/'.$photo_name));
        } 

        $data['editor_status'] = $request->editor_status;
        $data['editor_remarks'] = $request->editor_remarks;

        if($request->image_id){
            \DB::table('orders')
                    ->where('id', trim($request->image_id))
                    ->update($data);    
        }  

        $order = \DB::table('orders')
                    ->where('editor_id',Auth::user()->id)
                    ->get();           
        return view('dashboard.myorders',compact('order'));

    }
    public function changeOrderStatus(Request $request){ 
        $request_url = URL::previous();

        if (strpos($request_url, 'myorders') !== false) {
           if($request->image_id){
            \DB::table('orders') 
                    ->where('id',$request->image_id)
                    ->where('editor_id', Auth::user()->id)
                    ->update(['editor_status' => $request->status]);    
            } 

            $oid    =  \DB::table('orders')
                            ->where('id',$request->image_id)
                            ->first();

            $user   =   User::find($oid->user_id);  

            if($oid->editor_status==1){
                $s = "Pending";
            }elseif($oid->editor_status==2){
                $s = "In Progress";
            }elseif($oid->editor_status==3){
                $s = "Completed";
            }elseif($oid->editor_status==4){
                $s = "Rejected";
            }elseif($oid->editor_status==5){
                $s = "Cancel";
            }               

            $email_content = [
                'receipent_email'=> $user->email??null,
                'subject'=> 'Order status '.$s,
                'receipent_name'=>$user->first_name??null,
                'sender_name'=>'Edify team',
                'data' => 'Your current order status is '.$s.'.We will keep updating you.'
            ];
         
        $helper = new Helper;
        $mail = $helper->sendMail($email_content, 'testmail');
            
        $registatoin_ids=array();
        $registatoin_ids[]= $user->notification_id;
        $type = "Android";
        $message["title"] = 'Order status '.$s;
        $message["action"] = "notify";
        $message["message"] =  'Your current order status is '.$s.'.We will keep updating you.';        $fcmHelper = new FCMHelper;
        $fcmHelper->send_notification($registatoin_ids,$message,$type);
            
        }

        elseif (strpos($request_url, 'uploadEditedImage') !== false) {
           if($request->image_id){
            \DB::table('orders') 
                    ->where('id',$request->image_id)
                    ->where('editor_id', Auth::user()->id)
                    ->update(['editor_status' => $request->status]);    
            }

            if($request->status){

                $oid    =  \DB::table('orders')
                            ->where('id',$request->image_id)
                            ->first();
                $user   =   User::find($oid->user_id);  

                if($oid->editor_status==1){
                    $s = "Pending";
                }elseif($oid->editor_status==2){
                    $s = "In Progress";
                }elseif($oid->editor_status==3){
                    $s = "Completed";
                }elseif($oid->editor_status==4){
                    $s = "Rejected";
                
                }elseif($oid->editor_status==5){
                    $s = "Cancel";
                }               

                $email_content = [
                    'receipent_email'=> $user->email??null,
                    'subject'=> 'Order status '.$s,
                    'receipent_name'=>$user->first_name??null,
                    'sender_name'=>'Edify team',
                    'data' => 'Your current order status is '.$s.'.We will keep updating you.'
                ];
            }  
        }


        return redirect($request_url);
    }
    public function MyOrders()
    { 
        $order = \DB::table('orders')
                    ->where('editor_id',Auth::user()->id)
                    ->get();  

        return view('dashboard.myorders',compact('order'));
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
        $data = array(
            'first_name'    =>  $request->first_name,
            'last_name'     =>  $request->last_name,
            'email'         =>  $request->email_address,
            'phone'         =>  $request->mob,
            'skills'        =>  $request->skills,
            'qualification' =>  $request->qualification,
            'workExperience'=>  $request->workExperience

        ); 

        if ($request->file('profile_image')) {
            $photo = $request->file('profile_image');
            $destinationPath = storage_path('uploads/profile/');
            $photo_name = time().'.'.$photo->getClientOriginalExtension();
            $photo->move($destinationPath,  $photo_name);

            $request->merge(['profile_image'=>$photo_name]);  
            $data['profile_image']  = url::to(asset('storage/uploads/profile/'.$photo_name));
        } 

        $update = User::where('id',Session::get('editor_id'))->update($data);
        if($update)
        {
            Session::put('update_msg','Details Update Successfully');
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
            $img1_name = time().'.'.$img1->getClientOriginalExtension();
            $img1->move($destinationPath,  $img1_name);
        }
        if($request->hasFile('postafter'))
        {
            $img2 = $request->file('postafter');
            $destinationPath = storage_path('uploads/editor_test_imgs');
            
            $img2_name = time().'.'.$img2->getClientOriginalExtension();
            $img2->move($destinationPath,  $img2_name);

        }
        $data = array('eid'=>Session::get('editor_id'),'before_img'=>$img1_name,'after_img'=>$img2_name,'software'=>$request['sw'],'comment'=>$request['comment']);

        $insert = \DB::table('editor_post')->insert($data);
        if($insert)
        {
            Session::put('postuploadmsg','Data Inserted Completly');
            return redirect('postupload');
        }

    }

    
    public function uploadDocuments(Request $request)
    {
        
        if($request->hasFile('docUpload'))
        {
            $img1 = $request->file('docUpload');
            $destinationPath = storage_path('uploads/documents');

            $img_name = time().'.'.$img1->getClientOriginalExtension();
            $img1->move($destinationPath, $img_name);

        }
        $url = url('storage/uploads/documents/'.$img_name);
        $data = array('user_id'=>Auth::user()->id,'document'=>$request->document,'url'=>$url);
        $insert = \DB::table('documents')->insert($data);

        if($insert)
        {
            Session::put('storyuploadmsg','Document Uploaded Successffuly');
            return redirect('upload-document');
        }
    }

    public function UploadStories(Request $request)
    {
        if($request->hasFile('storyUpload'))
        {
            $img1 = $request->file('storyUpload');
            $destinationPath = storage_path('uploads/editor_stories_imgs');
           
            $img_name = time().'.'.$img1->getClientOriginalExtension();
            $img1->move($destinationPath, $img_name);
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
        Auth::logout();
        $request->session()->forget('login_status');
        return redirect('/');
    }

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
}
