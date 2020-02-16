<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
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
     * @param PostRequest $request
     *
     */
<<<<<<< HEAD
    public function store(PostRequest $request)
=======
    public function store(Post $post)
>>>>>>> e6dda136029c4da3b15d5ac25186913e5fc19e45
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
<<<<<<< HEAD
    public function show(PostRequest $posts)
=======
    public function show(Post $post)
>>>>>>> e6dda136029c4da3b15d5ac25186913e5fc19e45
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
<<<<<<< HEAD
    public function update(PostRequest $request)
=======
    public function update(Post $post)
>>>>>>> e6dda136029c4da3b15d5ac25186913e5fc19e45
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $posts
     * @return \Illuminate\Http\Response
     */
<<<<<<< HEAD
    public function destroy(PostRequest $posts)
=======
    public function destroy(Post $post)
>>>>>>> e6dda136029c4da3b15d5ac25186913e5fc19e45
    {
        //
    }


}
