<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model as Eloquent; 
 

class EditorPortfolio extends Eloquent {

     
   
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'editor_profiles';
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
    protected $fillable = ['title','category_name','software_editor','image_name','description', 'editor_id' , 'customer_id' ];  // All field of user table here    

    public function category()
    {
        return $this->hasOne('Modules\Admin\Models\Category', 'id' ,'category_name');
    }

   public function softwareEditor()
    {
        return $this->hasOne('Modules\Admin\Models\SoftwareEditor','id' , 'software_editor');
    }
  
}
