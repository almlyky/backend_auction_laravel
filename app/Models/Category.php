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
        'subCategory'
    ];
    public function subCategory()
    {
        return $this->hasMany($this::class, 'parent_id', 'id');
    }
    protected $appends=['subCategory'];
}
