<?php

namespace App;

use App\User;
use App\GalleryImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class GalleryImage extends Authenticatable
{
    protected $fillable = [
        'image_title',
        'user_id',
        'file_name', 
        'created_at'
    ];


  protected $table = 'images';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
       return $this->hasMany(ImageLike::class, 'image_id'); //here image_id is reference id of images table to likes table
    }

    public function likedByMe()
    {
        foreach($this->likes as $like) {
            if ($like->user_id == auth()->id()){
                return true;
            }
        }
        return false;
    }


}
