<?php

namespace App;

use App\Post;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Like extends Model
{
    use SoftDeletes;

     protected $fillable = [
        'user_id',
        'post_id'
    ];



}