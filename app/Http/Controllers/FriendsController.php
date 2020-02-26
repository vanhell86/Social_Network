<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;

class FriendsController extends Controller
{
    public function sendFriendRequest(User $user)
    {
        $authUser = Auth::user();

        if (! ($authUser->hasSentFriendRequest($user))) {       //check if auth user sent Friend request
            $authUser->friendRequestsOfThisUser()->attach($user, ['status' => 'pending']);
            return back()->with('Status', "You have sent friend request to  {$user->name}");
        }
        $authUser->friendRequestsOfThisUser()->detach($user);
        return back()->with('Status', "You have canceled friend request to  {$user->name}");
    }

    public function endFriendship(User $user)
    {
        $currentUser = Auth::user();

        if ($currentUser->isFriendWIth($user)) {
            $currentUser->friendsOfThisUser()->detach($user);
            $this->dettachFollowers($currentUser, $user);
            return back()->with('Status', "You quit your friendship with {$user->name}");
        }

        if ($currentUser->isFriendOf($user)) {
            $currentUser->thisUserFriendOf()->detach($user);
            $this->dettachFollowers($currentUser, $user);
            return back()->with('Status', "You quit your friendship with {$user->name}");
        }
    }

    public function acceptFriend(User $user)
    {
        $currentUser = Auth::user();

        $currentUser->friendRequestsToThisUser()->updateExistingPivot($user->id, ['status' => 'confirmed']);
        if (!$currentUser->isFollowing($user)) {
            $currentUser->follow()->attach($user);
        }
        if (!$user->isFollowing($currentUser)) {
            $currentUser->followers()->attach($user);
        }
        return back();
    }

    private function dettachFollowers(User $currentUser, User $user)
    {
        if ($currentUser->isFollowing($user)) {
            $currentUser->follow()->detach($user);
        }
        if ($user->isFollowing($currentUser)) {
            $currentUser->followers()->detach($user);
        }
    }
}
