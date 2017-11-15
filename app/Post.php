<?php

namespace App;

use App\User;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Post extends Authenticatable
{
    
    protected $fillable = [
        'title',
        'body',
        'user_id'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
