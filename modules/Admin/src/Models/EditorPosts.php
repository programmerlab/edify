<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model as Eloquent; 
 

class EditorPosts extends Eloquent {

     
   
    /**
     * The database table used by the model.
     *
     * @var string
     */ 
    protected $table = 'editor_post';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     /**
     * The primary key used by the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['eid','before_img','after_img' ]; 

    public function category()
    {
        return $this->hasOne('Modules\Admin\Models\Category', 'id' ,'category_name')->select('id','category_name','category_image','description',\DB::raw('CONCAT("https://edifyartist.com/storage/uploads/category/", "",category_image ) AS category_image_path'));
    }

   public function softwareEditor()
    {
        return $this->hasOne('Modules\Admin\Models\SoftwareEditor','id' , 'software_editor')->select('id','software_name','description','image_name',\DB::raw('CONCAT("https://edifyartist.com/storage/uploads/softwareEditor/", "",image_name ) AS image_path'));
    }

    public function editor()
    {
        return $this->hasOne('Modules\Admin\Models\User','id' , 'editor_id')->select('id','first_name','last_name','profile_image','phone');
    }
  }

