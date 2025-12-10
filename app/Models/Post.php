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
//     public function postImages()
// {
//     return $this->hasMany(PostImage::class, 'post_id');
// }
}
