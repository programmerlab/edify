<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model as Eloquent; 
 

class SoftwareEditor extends Eloquent {

    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'UploadedPics';
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
    protected $fillable = [
            'title','reference_image','original_image','modified_image','description', 
            'customer_id', 'editor_id' , 'status']; 

            // All field of user table here    

   public function customer()
    {
        return $this->hasOne('Modules\Admin\Models\User', 'customer_id','id');
    }

   public function editor()
    {
        return $this->hasOne('Modules\Admin\Models\User', 'editor_id','id');
    }
  
}
