<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
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
     *
     */
    public function index(Post $post)
    {
        return (new Post())->paginate(10);
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
     *
     * @param PostRequest $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostRequest $post):RedirectResponse
    {
        $post = (new Post($post->all()));
        $post->user_id = Auth::user()->getAuthIdentifier();
        $post->save();
        return back()->with('status', 'Post created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param Post $post
     * @return void
     */
    public function show(Post $post)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Post $post
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Post $post): View
    {
        return view('post/edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PostRequest $request
     * @param Post $post
     *
     */
    public function update(PostRequest $request,Post $post)
    {
        $post->update($request->all());
        return redirect(route('home'));
    }

    /**
     * Remove the specified resource from storage.
     *
     *
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect(route('home'));
    }


}
