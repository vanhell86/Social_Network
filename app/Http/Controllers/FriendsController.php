<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendsController extends Controller
{
    public function sendFriendRequest(User $user)
    {
        $userSendingRequest = Auth::user();

        if (is_null($userSendingRequest->hasSentFriendRequest($user))) {
            $userSendingRequest->friendRequestsOfThisUser()->attach($user,['status'=> 'pending']);
            return back()->with('Status', "You have sent friend request to  {$user->name}");
        } else {
            $userSendingRequest->friendRequestsOfThisUser()->detach($user);
            return back()->with('Status', "You have canceled friend request to  {$user->name}");
        }
    }

    public function endFriendship(User $user)
    {
        $currentUser = Auth::user();

        if($currentUser->isFriendWIth($user)){
            $currentUser->friendsOfThisUser()->detach($user);
            if($currentUser->isFollowing($user)){
                $currentUser->follow()->detach($user);
            }
            if($user->isFollowing($currentUser)){
                $currentUser->followers()->detach($user);
            }
            return back()->with('Status', "You quit your friendship with {$user->name}");

        }elseif($currentUser->isFriendOf($user)){
           $currentUser->thisUserFriendOf()->detach($user);
            if($currentUser->isFollowing($user)){
                $currentUser->follow()->detach($user);
            }
            if($user->isFollowing($currentUser)){
                $currentUser->followers()->detach($user);
            }
            return back()->with('Status', "You quit your friendship with {$user->name}");
        }
    }

    public function acceptFriend(User $user)
    {
        $currentUser = Auth::user();

        $currentUser->friendRequestsToThisUser()->updateExistingPivot($user->id,['status'=>'confirmed']);
        if(! $currentUser->isFollowing($user)){
            $currentUser->follow()->attach($user);
        }
        if(! $user->isFollowing($currentUser)){
            $currentUser->followers()->attach($user);
        }
        return back();
    }
}
