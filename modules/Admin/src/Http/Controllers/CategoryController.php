<?php
namespace Modules\Admin\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\CategoryRequest;
use Modules\Admin\Models\User; 
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
use DB;
use Route;
use Crypt;
use App\Http\Controllers\Controller;
use Illuminate\Http\Dispatcher; 
use App\Helpers\Helper;
use Modules\Admin\Models\Roles; 
use Modules\Admin\Models\Category;
 

/**
 * Class AdminController
 */
class CategoryController extends Controller {
    /**
     * @var  Repository
     */

    /**
     * Displays all admin.
     *
     * @return \Illuminate\View\View
     */
    public function __construct() { 
        $this->middleware('admin');
        View::share('viewPage', 'Category');
        View::share('sub_page_title', 'Group Category');
        View::share('helper',new Helper);
        View::share('heading','Group Category');
        View::share('route_url',route('category'));

        $this->record_per_page = Config::get('app.record_per_page');
    }

   
    /*
     * Dashboard
     * */

    public function index(Category $category, Request $request) 
    { 
        $page_title = 'Category';
        $sub_page_title = 'Group Category';
        $page_action = 'View Group Category'; 


        if ($request->ajax()) {
            $id = $request->get('id'); 
            $category = Category::find($id); 
            $category->status = $s;
            $category->save();
            echo $s;
            exit();
        }

        // Search by name ,email and group
        $search = Input::get('search');
        $status = Input::get('status');
        if ((isset($search) && !empty($search))) {

            $search = isset($search) ? Input::get('search') : '';
               
            $categories = Category::where(function($query) use($search,$status) {
                        if (!empty($search)) {
                            $query->Where('category_group_name', 'LIKE', "%$search%")
                                    ->OrWhere('category_name', 'LIKE', "%$search%");
                        }
                        
                    })->where('parent_id',0)->Paginate($this->record_per_page);
        } else {
            $categories = Category::where('parent_id',0)->Paginate($this->record_per_page);
        }
         
        
        return view('packages::category.index', compact('categories', 'page_title', 'page_action','sub_page_title'));
    }

    /*
     * create Group method
     * */

    public function create(Category $category) 
    {
         
        $page_title = 'Category';
        $page_action = 'Create Group Category';
        $category  = Category::all();
        $sub_category_name  = Category::all();
 
        $url = '';
        $categories = '';

        return view('packages::category.create', compact('categories', 'url','category','sub_category_name', 'page_title', 'page_action'));
    }

    /*
     * Save Group method
     * */

    public function store(CategoryRequest $request, Category $category) 
    {  
        $name = $request->get('category_group_name');
        $slug = str_slug($request->get('category_group_name'));
        $parent_id = 0;

        $photo = $request->file('category_group_image');
        $destinationPath = storage_path('uploads/category');
        $photo->move($destinationPath, time().$photo->getClientOriginalName());
        $photo_name = time().$photo->getClientOriginalName();
        $request->merge(['photo'=>$photo_name]);
 

        $cat = new Category;
        $cat->category_group_name   =  $request->get('category_group_name');
        $cat->slug                  =  strtolower(str_slug($request->get('category_group_name')));
        $cat->parent_id             =  $parent_id;
        $cat->category_name         =  $request->get('category_group_name'); 
        $cat->level                 =  1;
        $cat->category_group_image  =  $photo_name; 
        $cat->description           =  $request->get('description');
        
        $cat->save();   
         
        return Redirect::to(route('category'))
                            ->with('flash_alert_notice', 'New category  successfully created !');
        }

    /*
     * Edit Group method
     * @param 
     * object : $category
     * */

    public function edit($id) {
        $category = Category::find($id);
        $page_title = 'Category';
        $page_action = 'Edit Group category'; 
        $url = url::asset('storage/uploads/category/'.$category->category_group_image)  ;
        return view('packages::category.edit', compact( 'url','category', 'page_title', 'page_action'));
    }

    public function update(CategoryRequest $request,  $id) {
        $category = Category::find($id);
        $name = $request->get('category_group_name');
        $slug = str_slug($request->get('category_group_name'));
        $parent_id = 0;

        $validate_cat = Category::where('category_group_name',$request->get('category_group_name'))
                            ->where('parent_id',0)
                            ->where('id','!=',$category->id)
                            ->first();
         
        if($validate_cat){
              return  Redirect::back()->withInput()->with(
                'field_errors','The Group Category name already been taken!'
            );
        } 


        if ($request->file('category_group_image')) {
            $photo = $request->file('category_group_image');
            $destinationPath = storage_path('uploads/category');
            $photo->move($destinationPath, time().$photo->getClientOriginalName());
            $photo_name = time().$photo->getClientOriginalName();
            $request->merge(['photo'=>$photo_name]);
        } 

        $cat                        = Category::find($category->id);
        $cat->category_group_name   =  $request->get('category_group_name');
        $cat->slug                  =  strtolower(str_slug($request->get('category_group_name')));
        $cat->parent_id             =  $parent_id;
        $cat->category_name         =  $request->get('category_group_name'); 
        $cat->level                 =  1;
        $cat->description           =  $request->get('description');

        if(isset($photo_name))
        {
          $cat->category_group_image  =  $photo_name; 
        }
         
        $cat->save();    


        return Redirect::to(route('category'))
                        ->with('flash_alert_notice', 'Group Category  successfully updated.');
    }
    /*
     *Delete User
     * @param ID
     * 
     */
    public function destroy($category) {
        
        Category::where('id',$category)->delete(); 
        Category::where('parent_id',$category)->delete();
        return Redirect::to(route('category'))
                        ->with('flash_alert_notice', 'Group Category  successfully deleted.');
    }

    public function show(Category $category) {
        
    }

}
