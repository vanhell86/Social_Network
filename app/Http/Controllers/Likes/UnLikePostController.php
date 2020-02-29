<?php

namespace App\Http\Controllers\Likes;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

class UnLikePostController extends Controller
{
    public function __invoke(Post $post)
    {
        $post->likes()->where(['user_id' => Auth()->id()])->delete();
        return back();
    }
}
