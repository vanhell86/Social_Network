<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Photo extends Model
{
    protected $fillable = ['user_id', 'album_id','photo', 'title', 'size', 'description'];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPhoto()
    {
        return Storage::url("uploads/$this->user_id/albums/$this->album_id/". $this->photo);
    }
}
