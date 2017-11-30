<?php

namespace App\Http\Controllers;

use App\User;

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



    public function getPosts()
    {
        $posts = Post::with('user')
                     ->with(['likes' => function ($query) {
                                $query->whereNull('deleted_at');
                                $query->where('user_id', auth()->user()->id);
                            }])
                        ->get();
        $response = new Response(json_encode($posts));
        $response->headers->set('Content-Type', 'application/json'); 
       

        $data = $posts->map(function(Post $post)
        { 
            $user = auth()->user();

            if($user->can('delete', $post)) {
                $post['deletable'] = true;
            }

            if($user->can('update', $post)) {
                $post['update'] = true;
            }
             
            $post['likedByMe'] = $post->likes->count() == 0 ? false : true;
            $post['likesCount'] = Like::where('post_id', $post->id)->get()->count();
            $post['createdAt'] = $post->created_at->diffForHumans();
            $post['createdAt'] = $post->updated_at->diffForHumans();
            
            
            return $post;
        });

        return response()->json($data); 
    }

    public function getuserPosts($user)
    {
       $author = User::where('name','=', $user)->first();
       $posts = $author->posts()
                       ->with(['likes' => function ($query) {
                                $query->whereNull('deleted_at');
                            }])
                        ->get();
        $response = new Response(json_encode($posts));
        $response->headers->set('Content-Type', 'application/json'); 
       
        


        $data = $posts->map(function(Post $post)
        { 
            $user = auth()->user();

            if($user->can('delete', $post)) {
                $post['deletable'] = true;
            }

            if($user->can('update', $post)) {
                $post['update'] = true;
            }
             
            $post['likedByMe'] = Like::where('post_id', $post->id)->get()->count();
            $post['createdAt'] = $post->created_at->diffForHumans();
            $post['createdAt'] = $post->updated_at->diffForHumans();
            
            
            return $post;
        });

        return response()->json($data); 
    }
    
}
