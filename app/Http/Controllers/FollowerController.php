<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;


class followerController extends Controller
{

    public function followUser(User $user)
    {
        $follower = Auth::user();

        //$already_follow = $follower->follow()->where(['user_id' => $user->id, 'follower_id' => $follower->id])->first();

        if (is_null($follower->isFollowing($user))) {
            $follower->follow()->attach($user);
            return back()->with('Status', "You are now following  {$user->name}");
        } else {
            $follower->follow()->detach($user);
            return back()->with('Status', "You unfollowed {$user->name}");
        }
    }

}
