<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    //
    protected $fillable=[
        'post_id',
        'image_url',
        'is_main'
    ];
    public function getImageUrlAttribute($valure){
        return url($valure);
        
    }
    
    protected $hidden=['created_at','updated_at','post_id','id'];
}
