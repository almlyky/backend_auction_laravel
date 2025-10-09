<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $fillable=[
        'name',
        'address',
        'discribtion',
        'price',
        'status',
        'product_status',
        'user_id',
        'category_id'
    ];
}
