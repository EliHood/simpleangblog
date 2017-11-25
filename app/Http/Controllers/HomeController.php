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

    

       
        return view('home');
    }


    public function getPosts()
    {
        $posts = Post::with('user')->get();
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
            return $post;
        });

        return response()->json($data); 
    }
    
}
