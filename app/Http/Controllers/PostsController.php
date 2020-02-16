<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

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
     *
     */
    public function create()
    {
        return view('post/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     *
     * @param Request $request
     * @return Post
     */
    public function store(Post $post)
    {
        $post = (new Post($post->all()));
        $post->user_id = Auth::user()->getAuthIdentifier();
        $post->save();
        return $post;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $posts
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
        var_dump('Testing');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $posts
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $posts
     * @return \Illuminate\Http\Response
     */
    public function update(Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $posts
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }


}
