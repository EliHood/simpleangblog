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

        //Relationships
    //People who follow this user
    public function followers()
    {   
        return $this->hasMany('App\MyFollow','followable_id','user_id');
    }
    //Relationships
    //People who this user follows
    public function follow()
    {   
        return $this->hasMany('App\MyFollow','user_id','followable_id');
    }



}
