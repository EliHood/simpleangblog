<?php

namespace App\Http\Controllers;
use App\Post;
use App\User;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $post)
    {

        $data = request()->validate([
         'comment_body' => 'required|max:1000'
        ]);


        $data['user_id'] = auth()->user()->id;
        $data['name'] = auth()->user()->name;
        $data['post_id'] = $post;
        $post = Comment::create($data);
        // sets a time on a comment instantly im using angular :)
        $data['created_at_formatted'] = $post->created_at->diffForHumans();


        $response = new Response(json_encode($data));
        $response->headers->set('Content-Type', 'application/json'); 

        if(!$response){
            return 'something went wrong';
        }
        
        return response()->json($data); 
           

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
