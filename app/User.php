<?php

namespace App;
use App\User;
use App\Post;
use App\GalleryImage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\MyFollow;
use Overtrue\LaravelFollow\Traits\CanFollow;
use Overtrue\LaravelFollow\Traits\CanBeFollowed;

class User extends Authenticatable
{
    use Notifiable,CanFollow, CanBeFollowed;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function posts()
    {
        return $this->hasMany(Post::class);

    }


    public function images()
    {
        return $this->hasMany(GalleryImage::class, 'user_id');

    }

    public function getIsFollowingAttribute()
    {   
        return MyFollow::where('followable_id',$this->attributes['id'])->where('user_id',Auth()->user()->id)->count() > 0 ? true : false;
    }


    public function likes()
    {
        return $this->hasMany('App\Like');
    }

    public function follow()
    {   
        return $this->hasMany('App\MyFollow');
    }


    
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    


}
