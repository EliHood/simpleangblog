<?php

namespace App;

use App\GalleryImage;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImageLike extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'image_id'
    ];

}
