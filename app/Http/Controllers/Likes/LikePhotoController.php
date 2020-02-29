<?php

namespace App\Http\Controllers\Likes;

use App\Http\Controllers\Controller;
use App\Photo;

class LikePhotoController extends Controller
{
    public function __invoke(Photo $photo)
    {
        $photo->likes()->create(['user_id' => Auth()->id()]);
        return back();
    }
}
