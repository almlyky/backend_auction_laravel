<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Favorite extends Model
{
    protected $fillable = ['user_id', 'post_id'];
    protected $hidden = ['created_at', 'updated_at','post_id'];

    function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
        // return $this->hasMany(Post::class, 'id', 'post_id');
    }
}
