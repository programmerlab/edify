<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model as Eloquent; 
 

class Category extends Eloquent {

     
     protected $parent = 'parent_id';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'categories';
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
    protected $fillable = ['category_group_name','category','description'];  // All field of user table here    


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    public function subcategory()
    {
       
        return $this->belongsTo('Modules\Admin\Models\Category','id','parent_id');
    }

    public function parent()
    {
        return $this->belongsTo('Modules\Admin\Models\Category', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('Modules\Admin\Models\Category', 'parent_id','id');
    }

    public function groupCategory()
    {
        return $this->hasMany('Modules\Admin\Models\Category', 'parent_id','id');
    }

    public function category()
    {
        return $this->belongsTo('Modules\Admin\Models\Category', 'parent_id');
    }

    public function categoryDashboard()
    {
        return $this->hasOne('Modules\Admin\Models\CategoryDashboard', 'category_id','id');
    } 

    public function otherCategory()
    {
        return $this->hasMany('Modules\Admin\Models\Category', 'parent_id','id');
    }
    
    public function taskByCategory()
    {
        return $this->hasMany('App\Models\Tasks', 'categoryId','id')->with('postUserDetail');
    }
      
  
}
