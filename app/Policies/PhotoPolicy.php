<?php

namespace App\Policies;

use App\Photo;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PhotoPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return (int)auth()->user()->id === (int)$user->id;
    }


    public function view(User $user, Photo $photo)
    {
        $userIds = $user->follow()->pluck('user_id');
        $userIds[] = $user->id;
        return $userIds->contains($photo->user_id);
    }

    public function create(User $user)
    {
        return (int)auth()->user()->id === (int)$user->id;
    }

    public function update(User $user, Photo $photo)
    {
        return (int)$photo->user_id === (int)$user->id;
    }

    public function delete(User $user, Photo $photo)
    {
        return (int)$photo->user_id === (int)$user->id;
    }

}
