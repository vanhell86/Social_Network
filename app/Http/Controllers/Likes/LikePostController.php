<?php

namespace App\Http\Controllers\Likes;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

class LikePostController extends Controller
{
    public function __invoke(Post $post)
    {
       $post->likes()->create(['user_id' => Auth()->id()]);
       return back();
    }
}
