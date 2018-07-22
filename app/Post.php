<?php

namespace App;

use App\User;
use App\Comment;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;



class Post extends Authenticatable
{
   

    protected $fillable = [
        'title',
        'body',
        'user_id',
        'created_at',
        
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function likes()
    {
         return $this->hasMany('App\Like');
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
