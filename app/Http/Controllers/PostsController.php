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


    public function index()
    {
        $this->authorize('viewAny', Post::class);
        return Post::paginate(10);
    }


    public function create()
    {
        $this->authorize('create', Post::class);
        return view('post/create');
    }


    public function store(PostRequest $request):RedirectResponse
    {
        $this->authorize('create', Post::class);
        $post = (new Post(request()->all()));
        auth()->user()->posts()->save($post);
        return back()->with('AddNewPost', 'Post created successfully!');
    }

    public function show(Post $post)
    {
        $this->authorize('view', $post);
        return view('post/show', compact('post'));
    }

    public function edit(Post $post): View
    {
        $this->authorize('update', $post);
        return view('post/edit', ['post' => $post]);
    }

    public function update(PostRequest $request,Post $post)
    {
        $this->authorize('update', $post);
        $post->update($request->all());
        return redirect(route('home'));
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return redirect(route('home'));
    }
}
