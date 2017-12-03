<?php

namespace App\Http\Controllers;

use App\User;
use App\Comment;
use App\Post;
use App\Like;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    

       
        return view('home');
    }



    public function getPosts( )
    {
        $posts = Post::with('user')
                     ->with(['likes' => function ($query) {
                                $query->whereNull('deleted_at');
                                $query->where('user_id', auth()->user()->id);
                            }])
                      ->with(['comments' => function($query) {
        
                            $query->with('user');

                        }])

                        ->get();

        $data = $posts->map(function(Post $post )
        { 
            $user = auth()->user();

            if($user->can('delete', $post)) {
                $post['deletable'] = true;
            }

            if($user->can('update', $post)) {
                $post['update'] = true;
            }


            if($user->comments()){
                $post['commentt'] = true;
            }


            $post['likedByMe'] = $post->likes->count() == 0 ? false : true;
            $post['likesCount'] = Like::where('post_id', $post->id)->get()->count();
            $post['createdAt'] = $post->created_at->diffForHumans();
            $post['createdAt'] = $post->updated_at->diffForHumans();
            $post['comment_createdAt'] = $post->created_at->diffForHumans();
            
            return $post;
        });

        return response()->json($data); 
    }

    
    
}
