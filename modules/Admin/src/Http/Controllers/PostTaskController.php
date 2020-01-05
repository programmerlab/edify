<?php
namespace Modules\Admin\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\ContactRequest;
use Modules\Admin\Models\User;
use App\Models\Offers;
use App\Models\Tasks;
use Input;
use Validator;
use Auth;
use Paginate;
use Grids;
use HTML;
use Form;
use Hash;
use View;
use URL;
use Lang;
use Session; 
use Route;
use Crypt; 
use App\Http\Controllers\Controller;
use Illuminate\Http\Dispatcher; 
use App\Helpers\Helper;
use Modules\Admin\Models\Contact; 
use Modules\Admin\Models\Role;
use Modules\Admin\Models\Category;
use Modules\Admin\Models\ContactGroup;
use Response; 
use Maatwebsite\Excel\Facades\Excel as Excel;
use PDF;
use Modules\Admin\Models\PostTask;

/**
 * Class AdminController
 */
class PostTaskController extends Controller {
    /**
     * @var  Repository
     */

    protected $stockSettings = array();
    protected $modelNumber = '';

    private    $sub_sql =  "( case when status = 'completed' then 0 when  COALESCE(dueDate,CURRENT_DATE) < current_date then 1 when status = 'open'then 3 when status = 'assigned' then 2    end )as rank";
    private    $sub_sql_offer_count     = '(SELECT COUNT(*) as count from   offers where offers.taskId=post_tasks.id) as offer_count';
    private    $sub_sql_comment_count   = '(SELECT COUNT(*) as count from   comments where comments.taskId=post_tasks.id) as comment_count';

    private $sub_status = '(
                        CASE 
                        when COALESCE(dueDate,CURRENT_DATE) < current_date AND status ="open" then "expired"
                        ELSE 
                        status end) as status'; 


    private $doerRating     = '(SELECT ROUND( AVG(doerRating),1) from reviews LEFT  JOIN post_tasks on review.taskId=post_tasks.id ) as doerAvgRating';
    private $posterRating   = '(SELECT ROUND(AVG(posterRating),1) from reviews LEFT JOIN post_tasks on review.posterUserId=post_tasks.userId) as posterAvgRating';
                                         
    private $trns_status = '(
                        CASE 
                        when  status=-1 then "Failed"
                        when  status=1 then "Success"
                        when  status=2 then "Pending"
                        when  status=3 then "Failed" 
                        ELSE 
                        status end) as status';

    /**
     * Displays all admin.
     *
     * @return \Illuminate\View\View
     */
    public function __construct(Contact $contact) { 
        $this->middleware('admin');
        View::share('viewPage', 'Post Task');
        View::share('sub_page_title', 'Post Task Detail');
        View::share('helper',new Helper);
        View::share('heading','Post Task');
        View::share('route_url',route('postTask')); 
        $this->record_per_page = Config::get('app.record_per_page'); 
    }

   
    /*
     * Dashboard
     * */
    public function index(Contact $contact, Request $request) 
    { 
        $page_title = 'Post Task';
        $sub_page_title = 'View Post Task Detail';
        $page_action = 'View Post Task Detail'; 

        if ($request->ajax()) {
            $id = $request->get('id'); 
            $category = PostTask::find($id); 
            $category->status = $s;
            $category->save();
            echo $s;
            exit();
        } 
        $currency = \DB::table('settings')->where('field_key','currency')->first();
 
        // Search by name ,email and group
        $search = Input::get('search');
        $taskdate = Input::get('taskdate');
        if ((isset($search) && !empty($search)) || (isset($taskdate) && !empty($taskdate)) ) {
            $search = isset($search) ? Input::get('search') : null; 
            $taskdate = isset($taskdate) ? $taskdate : null; 
            $postTasks = PostTask::with('user')->where(function($query) use($search,$taskdate) {
                if (!empty($search)) {
                    $query->Where('title', 'LIKE', "%$search%"); 
                }
               if($taskdate){
                     $query->Where('created_at', 'LIKE', "%$taskdate%");
                }

            })->Paginate($this->record_per_page);
        } else {
            $postTasks = PostTask::with('user')->orderBy('id','desc')->Paginate($this->record_per_page);
        }
           
        return view('packages::postTask.index', compact('postTasks', 'page_title', 'page_action','sub_page_title','currency'));
    }

    /*
     * create Group method
     * */

    public function create(Contact $contact) 
    { 
    }

    public function createGroup(Request $request)
    { 
    }

    public function mytask(Request $request, $uid=112)
    {
        $page_title = "Client Users";
        $page_action = "Task";
        $sub_page_title = "My Task";

        $user = User::find($uid);

        if(!$user){
           return Redirect::to('admin/clientuser');
        }


        $postTasks =  PostTask::where('userId',$uid)->where('status','open')->get();
        $expireTasks =  PostTask::where('userId',$uid)->where('status','open')
                        ->whereDate('dueDate','<',\Carbon\Carbon::today()->toDateString())->get();
        $completedTasks =  PostTask::where('taskDoerId',$uid)->where('status','completed')->get();
        $inprogressTasks =  PostTask::where('taskDoerId',$uid)->where('status','inprogresss')->get();
          
        $userDetail = User::find($uid)->toArray(); 
        $role = Role::select('name')->find($userDetail['role_type']);
        if($role ){
            $role =$role->toArray() ;  
        }else{
            $role =null; 
        }
 
        $userDetail['Role Type'] = isset($role['name'])?$role['name']:'NA';
        unset($userDetail['role_type']);

        $offer_pending =  PostTask::where('taskOwnerId',$uid)->where('status','open')->lists('id');

        $offerPending =  Offers::with('mytask','interestedPeope')->whereIn('taskId',$offer_pending)->get();
 

        $offerAssigned =  PostTask::where('taskOwnerId',$uid)->where('status','assigned')->get();
 

        return view('packages::users.mytask', compact('userDetail','user','inprogressTasks','completedTasks','expireTasks','postTasks','data', 'page_title', 'page_action','sub_page_title','offerPending','offerAssigned'));
    }

    /*
     * Save Group method
     * */

    public function store(ContactRequest $request, Contact $contact) 
    {   
        
        $categoryName = $request->get('categoryName');
        $cn= '';
        foreach ($categoryName as $key => $value) {
            $cn = ltrim($cn.','.$value,',');
        }
;        
        $table_cname = \Schema::getColumnListing('contacts');
        $except = ['id','create_at','updated_at','categoryName'];
        $input = $request->all();
        $contact->categoryName = $cn;
        foreach ($table_cname as $key => $value) {
           
           if(in_array($value, $except )){
                continue;
           }

           if(isset($input[$value])) {
               $contact->$value = $request->get($value); 
           } 
        }
        $contact->save();   
         
        return Redirect::to(route('contact'))
                            ->with('flash_alert_notice', 'New contact successfully created!');
    }
    
    public function uploadFile($file)
    {
       
        //Display File Name
        $fileName = $file->getClientOriginalName();

        //Display File Extension
        $ext = $file->getClientOriginalExtension();
        //Display File Real Path
        $realPath = $file->getRealPath(); 
        //Display File Mime Type
        

        $file_name = time().'.'.$ext;
        $path = storage_path('csv');

        chmod($path ,0777);
        $file->move($path,$file_name);
        chmod($path.'/'.$file_name ,0777);
        return $path.'/'.$file_name;
    }

    public function contactImport(Request $request)
    {
        try{
            $file = $request->file('importContact');
            
            if($file==NULL){
                echo json_encode(['status'=>0,'message'=>'Please select  csv file!']); 
                exit(); 
            }
            $ext = $file->getClientOriginalExtension();
            if($file==NULL || $ext!='csv'){
                echo json_encode(['status'=>0,'message'=>'Please select valid csv file!']); 
                exit(); 
            }
            $mime = $file->getMimeType();   
           
            $upload = $this->uploadFile($file);
           
            $rs =    \Excel::load($upload, function($reader)use($request) {

            $data = $reader->all(); 
              
            $table_cname = \Schema::getColumnListing('contacts');
            
            $except = ['id','create_at','updated_at'];

            $input = $request->all();
           // $contact->categoryName = $cn;
            $contact =  new Contact;
            foreach ($data  as $key => $result) {
                foreach ($table_cname as $key => $value) {
                   if(in_array($value, $except )){
                        continue;
                   }
                   if(isset($result->$value)) {
                       $contact->$value = $result->$value; 
                       $status = 1;
                   } 
                }
                 if(isset($status)){
                     $contact->save(); 
                 }
            } 
           
            if(isset($status)){
                echo json_encode(['status'=>1,'message'=>'contact imported successfully!']);
            }else{
               echo json_encode(['status'=>0,'message'=>'Invalid file type or content.Please upload csv file only.']); 
            }
             
            });

        } catch (\Exception $e) {
            echo json_encode(['status'=>0,'message'=>'Please select csv file!']); 
            exit(); 
        }
        
       
    }

    /*
     * Edit Group method
     * @param 
     * object : $category
     * */

    public function edit(Contact $contact) {
        $page_title     = 'contact';
        $page_action    = 'Edit contact'; 
        $categories  = Category::all();
        $category_id  = explode(',',$contact->categoryName);
        
        return view('packages::contact.edit', compact('category_id','categories', 'url','contact', 'page_title', 'page_action'));
    }

    public function update(Request $request, Contact $contact) {
        
        $contact = Contact::find($contact->id); 
        $categoryName = $request->get('categoryName');
        $cn= '';
        foreach ($categoryName as $key => $value) {
            $cn = ltrim($cn.','.$value,',');
        }
    
        if($cn!=''){
            $contact->categoryName =  $cn;
        }
        $request = $request->except('_method','_token','categoryName');
        
        foreach ($request as $key => $value) {
            $contact->$key = $value;
        }
        $contact->save();
        return Redirect::to(route('contact'))
                        ->with('flash_alert_notice', 'Contact  successfully updated.');
    }
    /*
     *Delete User
     * @param ID
     * 
     */
    public function destroy($id) { 
        PostTask::where('id',$id)->delete(); 
        return Redirect::to(route('postTask'))
                        ->with('flash_alert_notice', 'Post Task  successfully deleted.');
    }

    public function show( $id) {
        $postTask = PostTask::find($id);
        $page_title = 'Post Task Detail';
        $sub_page_title = 'View Post Task Detail';
        $page_action = 'View Post Task Detail'; 

        $postTasks = PostTask::with('user')->where('id',$postTask->id)->first(); 

        $table_cname = \Schema::getColumnListing('post_tasks');
         
            //echo Carbon::createFromFormat('Y-m-d H', '1975-05-21 22')->toDateTimeString();
        $postBy = \Carbon\Carbon::parse($postTasks->created_at)->format('d M,Y');

        $taskPostDate = \Carbon\Carbon::parse($postTasks->created_at)->format('d M,Y');
        $taskdueDate = \Carbon\Carbon::parse($postTasks->dueDate)->format('d M,Y');
        
        $comments =  \App\Models\Comments::with('userDetail')->where('taskId',$postTask->id)->get();

        $doer =  User::find($postTask->taskDoerId);

        if($doer){
            $doer = $doer->toArray();
        }else{
            $doer = null;
        }

        $offers =  Offers::with('interestedPeope')->where('taskId',$postTask->id)->get(); 

        $currency = \DB::table('settings')->where('field_key','currency')->first();
        
        $posterUser = ($postTasks->user)->toArray(); 


        return view('packages::postTask.main', compact('comments','postBy','postTasks','offers','doer', 'page_title', 'page_action','sub_page_title','table_cname','taskPostDate','taskdueDate','currency','posterUser'));
       
    }

}