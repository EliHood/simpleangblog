<?php

namespace App\Traits;

trait Likes {

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