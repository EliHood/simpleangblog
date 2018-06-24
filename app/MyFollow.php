<?php

namespace App;

use App\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Overtrue\LaravelFollow\Traits\CanFollow;
use Overtrue\LaravelFollow\Traits\CanBeFollowed;

class MyFollow extends Model
{
	use SoftDeletes, CanFollow, CanBeFollowed;

    protected $fillable = [
        'user_id',
        'followable_id'
    ];

    public $timestamps = false;

    protected $table = 'followables';

    public function follower()
    {
        return $this->belongsTo('App\User', 'followable_id');
    }

    public function followedByMe()
    {
        foreach($this->follower as $followers) {
            if ($followers->user_id == auth()->id()){
                return true;
            }
        }
        return false;
    }


}
