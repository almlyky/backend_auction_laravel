<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    //
    use SoftDeletes;
    protected $fillable=[
        'name',
        'address',
        'discribtion',
        'price',
        'status',
        'product_status',
        'user_id',
        'category_id',
        'images',
        
    ];
    protected $hidden=['updated_at'];
    protected $appends=['images','fav'];
    public function getImagesAttribute(){
        return PostImage::where('post_id',$this->id)->get();
    }
     public function getFavAttribute(){
          $userId = auth('api')->id();
           // الحصول على معرف المستخدم الحالي
        if (!$userId) {
            return 0; // إذا لم يكن هناك مستخدم مسجل الدخول
        }

        return Favorite::where('user_id', $userId)->where('post_id', $this->id)->exists() ? 1 : 0;
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'reported_post_id');
    }
}
