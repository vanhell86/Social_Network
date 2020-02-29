<?php

namespace App\Policies;

use App\Post;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;


    public function viewAny(User $user)
    {
        return (int)auth()->user()->id === (int)$user->id;
    }


    public function view(User $user, Post $post)
    {
        $userIds = $user->follow()->pluck('user_id');
        $userIds[] = $user->id;
        return $userIds->contains($post->user_id);
    }


    public function create(User $user)
    {
        return (int)auth()->user()->id === (int)$user->id;
    }


    public function update(User $user, Post $post)
    {
        return (int)$post->user_id === (int)$user->id;
    }


    public function delete(User $user, Post $post)
    {
        return (int)$post->user_id === (int)$user->id;
    }

}
