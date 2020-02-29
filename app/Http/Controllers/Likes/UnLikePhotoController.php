<?php

namespace App\Http\Controllers\Likes;

use App\Http\Controllers\Controller;
use App\Photo;
use Illuminate\Http\Request;

class UnLikePhotoController extends Controller
{
    public function __invoke(Photo $photo)
    {
        $photo->likes()->where(['user_id' => Auth()->id()])->delete();
        return back();
    }
}
