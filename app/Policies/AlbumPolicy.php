<?php

namespace App\Policies;

use App\Album;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AlbumPolicy
{
    use HandlesAuthorization;


    public function viewAny(User $user)
    {
        return (int) auth()->user()->id === (int) $user->id;
    }


    public function view(User $user, Album $album)
    {
        $userIds = $user->follow()->pluck('user_id');
        $userIds[] = $user->id;
        return $userIds->contains($album->user_id);
    }


    public function create(User $user)
    {
        return (int) auth()->user()->id === (int) $user->id;
    }


    public function update(User $user, Album $album)
    {
        return (int) $album->user_id === (int) $user->id;
    }


    public function delete(User $user, Album $album)
    {
        return (int) $album->user_id === (int) $user->id;
    }
}
