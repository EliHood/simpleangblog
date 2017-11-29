<?php

namespace App;

use App\User;
use App\Like;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Post extends Authenticatable
{
    
    protected $fillable = [
        'title',
        'body',
        'user_id',
        'created_at'
    ];




    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
         return $this->belongsToMany('App\User', 'likes');
    }

    



}
