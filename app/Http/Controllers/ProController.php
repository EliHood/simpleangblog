<?php

namespace App\Http\Controllers;


use App\User;
use App\Comment;
use App\Post;
use App\Like;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class ProController extends Controller
{

 

	public function index($user)
    {
      $users = User::with(['posts.likes' => function($query) {
                            $query->whereNull('deleted_at');
                           
                        }, 'followers','follow.followers'])

                        ->with(['followers' => function($query) {
                 

                        }])->where('name','=', $user)->first();



        return response()->json($users); 
    }

}
