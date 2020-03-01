<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model as Eloquent; 

class EditorTest extends Eloquent
{
    protected $table = 'editor_test';

    protected $fillable = ['eid','img1','img2', 'img3', 'img1_status', 'img2_status', 'img3_status'];
}
