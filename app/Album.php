<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Album extends Model
{
    protected $fillable = ['user_id','name', 'description','cover_image'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function getAlbumCover()
    {
        return Storage::url("uploads/$this->user_id/album_covers/". $this->cover_image);
    }

}

