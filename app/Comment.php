<?php

namespace App;

use App\User;
use App\Post;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
    	'comment_body',
        'user_id',
        'post_id', 
        'created_at'

    ];

    protected $appends = ['created_at_formatted'];

    public function user()
	{
	    return $this->belongsTo('App\User'); 
	}

	public function post()
    {
        return $this->belongsTo('App\Post');
    }

    public function getCreatedAtFormattedAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
