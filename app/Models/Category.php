<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $fillable=[
        "name_ar",
        "name_en",
        "parent_id",
    ];
    protected $hidden=['created_at','updated_at'];
     public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}