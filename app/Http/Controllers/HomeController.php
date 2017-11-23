<?php

namespace App\Http\Controllers;

use App\User;
use App\Post;
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

        $posts = Post::with('user')->get()->map(function(Post $post){ 
        return collect($post->toArray())->put('deletable', auth()->user()->can('delete', $post)); 
        });

       
        return view('home');
    }

    public function getPosts()
    {

        $posts = Post::with('user')->get();
        $response = new Response(json_encode($posts));
        $response->headers->set('Content-Type', 'application/json'); 
        return response()->json(Post::with('user')->get()->map(function(Post $post){ 
            return collect($post->toArray())->put('deletable', auth()->user()->can('delete', $post)); 
        })); 
    }

    

    
}
