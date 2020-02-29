<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Post extends Model
{
    protected $fillable = ['user_id', 'title', 'content'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function liked()
    {
        return $this->likes()->where('user_id', Auth()->id())->count() > 0;
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function countLikes()
    {
        return $this->likes()->count();
    }
}
