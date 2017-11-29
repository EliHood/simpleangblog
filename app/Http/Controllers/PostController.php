<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use App\Like;
use App\Policies\TaskPolicy; // in App/Providers/AuthServiceProvider.php


use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function isLikedByMe($id)
    {
        if (Like::whereUserId(auth()->user()->id)
                 ->wherePostId($id)->exists()){
            return 'true';
        }
        return 'false';
    }


    public function getTotalLikes(Post $post)
    {
        $likes = Like::where('post_id', $post->id)->get();

        if($likes->count()){
            return $likes->count();
        }
        return 'no likes';



    }

    public function like(Post $post, Request $request)
    {
        $existing_like = Like::withTrashed()->wherePostId($post->id)->whereUserId(auth()->id())->first();

        if (is_null($existing_like)) {
            Like::create([
                'post_id' => $post->id,
                'user_id' => auth()->user()->id
            ]);


        } else {
            if (is_null($existing_like->deleted_at)) {
                $existing_like->delete();
            } else {
                $existing_like->restore();
            }
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storePost(Request $request)
    {
        $data = request()->validate([
         'body' => 'required|max:1000'
        ]);

        $data['user_id'] = auth()->user()->id;
        $data['name'] = auth()->user()->name;
        $owl = new Post();
        $data['created_at'] = $owl->created_at;




        $post = Post::create($data);
        $data['id'] = $post->id;

        $response = new Response(json_encode($data));
        $response->headers->set('Content-Type', 'application/json'); 


        // return redirect('/home')->withMessage('A new post was created.');
 
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {


        $post = Post::find($id);
        return response($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Post $post)
    {
        //
        $data = request()->validate([
            'body' => 'required|string'
        ]);


        $this->authorize('update', $post);
        
        $post->update($data);

        $response = new Response(json_encode($post));
        $response->headers->set('Content-Type', 'application/json'); 

        return $response;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post){
        
        $this->authorize('delete', $post);
        $postl =  Post::with('likes')->whereId($post)->delete();

        if ($post->delete()) {
    
            return response()->json(['message' => 'deleted']);
             
        }



        return response()->json(['error' => 'something went wrong'], 400);
    }
}
