<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;


class FollowerController extends Controller
{

    public function followUser(User $user)
    {
        $follower = Auth::user();

        if (is_null($follower->isFollowing($user))) {
            $follower->follow()->attach($user);
            return back()->with('Status', "You are now following  {$user->name}");
        }

        $follower->follow()->detach($user);
        return back()->with('Status', "You unfollowed {$user->name}");
    }

}
